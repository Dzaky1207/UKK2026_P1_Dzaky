<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::latest()->get();
        return view('Lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('Lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        $lokasi = Lokasi::create($request->only(['lokasi']));
        $this->logAktivitas('Buat', 'Lokasi', "Lokasi {$lokasi->lokasi} dibuat");

        return redirect()->route('Lokasi.index')->with('success', 'Lokasi berhasil ditambahkan');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('Lokasi.create', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        $lokasi->update($request->only(['lokasi']));
        $this->logAktivitas('Ubah', 'Lokasi', "Lokasi {$lokasi->lokasi} diubah");

        return redirect()->route('Lokasi.index')->with('success', 'Lokasi berhasil diupdate');
    }

    public function destroy(Lokasi $lokasi)
    {
        $nama = $lokasi->lokasi;
        $lokasi->delete();
        $this->logAktivitas('Hapus', 'Lokasi', "Lokasi {$nama} dihapus");

        return redirect()->route('Lokasi.index')->with('success', 'Lokasi berhasil dihapus');
    }

    protected function logAktivitas($aksi, $modul, $deskripsi)
    {
        LogAktivitas::create([
            'id_pengguna' => auth()->id(),
            'aksi' => $aksi,
            'modul' => $modul,
            'deskripsi' => $deskripsi,
            'alamat_ip' => request()->ip(),
        ]);
    }
}
