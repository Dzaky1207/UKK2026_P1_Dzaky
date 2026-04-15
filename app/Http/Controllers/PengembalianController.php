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

    public function create(Request $request)
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->with(['pengguna', 'alat'])->get();
        $peminjaman = Peminjaman::find($request->id_peminjaman);
        if ($peminjaman) {
            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);
        }

        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required',
            'tanggal_kembali' => 'required|date',
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('bukti')) {
            $filename = time() . '.' . $request->file('bukti')->extension();
            $request->file('bukti')->move(public_path('bukti'), $filename);

            $path = 'bukti/' . $filename;
        }

        Pengembalian::create([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'bukti' => $path,
            'id_petugas' => auth()->id()
        ]);

        // ✅ WAJIB
        $peminjaman = Peminjaman::find($request->id_peminjaman);
        if ($peminjaman) {
            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);
        }

        return back()->with('success', 'Alat berhasil dikembalikan');
    }
}
