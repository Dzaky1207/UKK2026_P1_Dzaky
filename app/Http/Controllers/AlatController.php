<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->get();
        return view('Alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('Alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'id_kategori' => 'nullable|exists:kategori,id',
            'jenis_item' => 'required|in:individu,bundel',
            'maksimal_poin_pelanggaran' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['id_kategori', 'nama_alat', 'jenis_item', 'maksimal_poin_pelanggaran', 'deskripsi']);
        $data['kode_slug'] = Str::slug($request->nama_alat);

        if ($request->file('foto')) {
            $data['path_foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat = Alat::create($data);
        $this->logAktivitas('Buat', 'Alat', "Alat {$alat->nama_alat} ditambahkan");

        return redirect()->route('Alat.index')->with('success', 'Alat berhasil ditambahkan');
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('Alat.create', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'id_kategori' => 'nullable|exists:kategori,id',
            'jenis_item' => 'required|in:individu,bundel',
            'maksimal_poin_pelanggaran' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['id_kategori', 'nama_alat', 'jenis_item', 'maksimal_poin_pelanggaran', 'deskripsi']);
        $data['kode_slug'] = Str::slug($request->nama_alat);

        if ($request->file('foto')) {
            $data['path_foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($data);
        $this->logAktivitas('Ubah', 'Alat', "Alat {$alat->nama_alat} diubah");

        return redirect()->route('Alat.index')->with('success', 'Alat berhasil diupdate');
    }

    public function destroy(Alat $alat)
    {
        $nama = $alat->nama_alat;
        $alat->delete();
        $this->logAktivitas('Hapus', 'Alat', "Alat {$nama} dihapus");

        return redirect()->route('Alat.index')->with('success', 'Alat berhasil dihapus');
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
