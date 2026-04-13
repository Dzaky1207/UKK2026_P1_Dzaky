<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
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
        $allAlat = Alat::where('jenis_item', 'individu')->get();
        return view('Alat.create', compact('kategoris', 'allAlat'));
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

        $data = $request->only([
            'id_kategori',
            'nama_alat',
            'jenis_item',
            'maksimal_poin_pelanggaran',
            'deskripsi'
        ]);

        $data['kode_slug'] = Str::slug($request->nama_alat);

        $filePath = null;

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/alat'), $filename);

                    $filePath = 'uploads/alat/' . $filename;
                    $data['path_foto'] = $filePath;
                }
            }

            $alat = Alat::create($data);

            if ($request->jenis_item === 'bundel' && $request->bundel) {
                foreach ($request->bundel as $item) {
                    if (!empty($item['id_alat'])) {
                        DB::table('bundel_alat')->insert([
                            'id_bundle' => $alat->id,
                            'id_alat' => $item['id_alat'],
                            'jumlah' => $item['jumlah'] ?? 1
                        ]);
                    }
                }
            }

            $this->logAktivitas('Buat', 'Alat', "Alat {$alat->nama_alat} ditambahkan");

            return redirect()->route('Alat.index')->with('success', 'Alat berhasil ditambahkan');
        } catch (\Exception $e) {

            if ($filePath && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }

            return back()->with('error', 'Gagal menyimpan data');
        }
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $allAlat = Alat::where('jenis_item', 'individu')->get();
        return view('Alat.create', compact('kategoris', 'alat', 'allAlat'));
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

        $data = $request->only([
            'id_kategori',
            'nama_alat',
            'jenis_item',
            'maksimal_poin_pelanggaran',
            'deskripsi'
        ]);

        $data['kode_slug'] = Str::slug($request->nama_alat);

        // 🔥 kalau upload foto baru
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if ($file->isValid()) {

                // ✅ hapus foto lama
                if ($alat->path_foto && File::exists(public_path($alat->path_foto))) {
                    File::delete(public_path($alat->path_foto));
                }

                // ✅ simpan foto baru
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/alat'), $filename);

                $data['path_foto'] = 'uploads/alat/' . $filename;
            }
        }

        $alat->update($data);

        // hapus bundel lama
        DB::table('bundel_alat')->where('id_bundle', $alat->id)->delete();

        // simpan ulang
        if ($request->jenis_item === 'bundel' && $request->bundel) {
            foreach ($request->bundel as $item) {
                if (!empty($item['id_alat'])) {
                    DB::table('bundel_alat')->insert([
                        'id_bundle' => $alat->id,
                        'id_alat' => $item['id_alat'],
                        'jumlah' => $item['jumlah'] ?? 1
                    ]);
                }
            }
        }

        $this->logAktivitas('Ubah', 'Alat', "Alat {$alat->nama_alat} diubah");

        return redirect()->route('Alat.index')->with('success', 'Alat berhasil diupdate');
    }

    public function destroy(Alat $alat)
    {
        $nama = $alat->nama_alat;

        if ($alat->path_foto && File::exists(public_path($alat->path_foto))) {
            File::delete(public_path($alat->path_foto));
        }

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
