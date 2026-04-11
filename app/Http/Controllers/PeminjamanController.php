<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['pengguna', 'alat'])
            ->where('status', '!=', 'dikembalikan')
            ->latest()
            ->get();
        $pengembalians = Pengembalian::latest()->get();

        return view('Peminjaman.index', compact('peminjamans', 'pengembalians'));
    }

    public function create()
    {
        $pengguna = User::where('role', 'user')->orderBy('name')->get();
        $alat = Alat::orderBy('nama_alat')->get();
        return view('Peminjaman.create', compact('pengguna', 'alat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:users,id',
            'id_alat' => 'required|exists:alat,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
            'tujuan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::create(array_merge($request->only(["id_pengguna", "id_alat", "tanggal_pinjam", "tanggal_jatuh_tempo", "tujuan", "catatan"]), ['status' => 'menunggu']));

        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman berhasil diajukan');
    }

    public function approve(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dipinjam', 'id_petugas' => auth()->id()]);

        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman telah disetujui');
    }

    public function reject(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'ditolak', 'id_petugas' => auth()->id()]);

        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman telah ditolak');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $pengguna = User::where('role', 'user')->orderBy('name')->get();
        $alat = Alat::orderBy('nama_alat')->get();
        return view('Peminjaman.create', compact('peminjaman', 'pengguna', 'alat'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:users,id',
            'id_alat' => 'required|exists:alat,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
            'tujuan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman->update($request->only(['id_pengguna', 'id_alat', 'tanggal_pinjam', 'tanggal_jatuh_tempo', 'tujuan', 'catatan']));

        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman berhasil diupdate');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $id = $peminjaman->id;
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);
        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}
