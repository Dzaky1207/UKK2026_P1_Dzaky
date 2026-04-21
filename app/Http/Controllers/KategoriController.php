<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('Kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('Kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::create($request->only(['nama_kategori', 'deskripsi']));
        $this->logAktivitas('Buat', 'Kategori', "Kategori {$kategori->nama_kategori} dibuat");

        return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('Kategori.create', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->only(['nama_kategori', 'deskripsi']));
        $this->logAktivitas('Ubah', 'Kategori', "Kategori {$kategori->nama_kategori} diubah");

        return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama_kategori;
        $kategori->delete();
        $this->logAktivitas('Hapus', 'Kategori', "Kategori {$nama} dihapus");

        return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    protected function logAktivitas($aksi, $modul, $deskripsi)
    {
        LogAktivitas::create([
            'id_pengguna' => Auth::id(),
            'aksi' => $aksi,
            'modul' => $modul,
            'deskripsi' => $deskripsi,
            'alamat_ip' => request()->ip(),
        ]);
    }
}
