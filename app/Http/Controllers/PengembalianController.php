<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\KondisiUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.pengguna',
            'peminjaman.alat',
            'petugas',
            'kondisiUnit',
        ])->latest()->get();

        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create(Request $request)
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->with(['pengguna', 'alat'])->get();

        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required',
            'tanggal_kembali' => 'required|date',
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $file = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $filename);

        Pengembalian::create([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'bukti' => 'uploads/bukti/' . $filename,
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Pengajuan pengembalian dikirim');
    }

    public function proses(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required_if:aksi,setujui',
        ]);

        $pengembalian = Pengembalian::with('peminjaman.pengguna')->findOrFail($id);

        if ($request->aksi == 'setujui') {

            // ✅ update status
            $pengembalian->status = 'disetujui';

            // ✅ simpan kondisi
            KondisiUnit::create([
                'id_pengembalian' => $id,
                'kondisi' => $request->kondisi,
                'catatan' => $request->catatan
            ]);

            // ✅ ubah status peminjaman
            $pengembalian->peminjaman->update([
                'status' => 'dikembalikan'
            ]);

            // ✅ cek telat
            if (now()->gt($pengembalian->peminjaman->tanggal_jatuh_tempo)) {
                $pengembalian->peminjaman->pengguna->increment('poin_pelanggaran', 10);
            }
        } else {
            $pengembalian->status = 'ditolak';
        }

        $pengembalian->id_petugas = Auth::user()->id;
        $pengembalian->save();

        return back()->with('success', 'Pengembalian diproses');
    }

    public function reject(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $pengembalian->status = 'ditolak';
        $pengembalian->catatan = $request->catatan; // simpan catatan

        $pengembalian->save();

        // simpan ke tabel kondisi_unit
        KondisiUnit::create([
            'kode_unit' => $request->kode_unit,
            'id_pengembalian' => $pengembalian->id,
            'kondisi' => $request->kondisi,
            'catatan' => $request->catatan
        ]);

        return back();
    }

    public function riwayat()
    {
        $pengembalians = \App\Models\Pengembalian::with(['peminjaman.user', 'kondisiUnit'])
            ->latest()
            ->get();

        return view('pengembalian.riwayat', compact('pengembalians'));
    }
}
