<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use App\Models\UnitAlat;

use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.pengguna', 'peminjaman.alat', 'petugas'])->latest()->get();
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->with(['pengguna', 'alat'])->get();
        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id',
            'tanggal_kembali' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::with(['pengguna', 'alat'])
                ->findOrFail($request->id_peminjaman);

            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id,
                'id_petugas' => auth()->id() ?? 1,
                'tanggal_kembali' => $request->tanggal_kembali,
            ]);

            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);

            // sementara jangan delete dulu
            // $peminjaman->delete();

            DB::commit();

            return redirect()->route('Peminjaman.index')
                ->with('success', 'Pengembalian berhasil');
        } catch (\Exception $e) {

            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
