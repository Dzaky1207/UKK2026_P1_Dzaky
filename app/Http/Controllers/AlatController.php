<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\Lokasi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori', 'units')
            ->whereNotIn('id', function ($query) {
                $query->select('id_alat')->from('bundel_alat');
            })
            ->latest()
            ->get();

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $allAlat = Alat::where('jenis_item', '!=', 'bundel')->get();
        $lokasis = Lokasi::all();

        return view('Alat.index', compact('alats', 'kategoris', 'allAlat', 'lokasis'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $allAlat = Alat::where('jenis_item', '!=', 'bundel')->get();
        $lokasis = \App\Models\Lokasi::all();

        return view('Alat.create', compact('kategoris', 'allAlat', 'lokasis'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'id_kategori' => 'nullable|exists:kategori,id',
            'jenis_item' => 'required|in:bundel,single,bundel_alat',
            'harga' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['id_kategori', 'nama_alat', 'jenis_item', 'maksimal_poin_pelanggaran', 'deskripsi', 'harga']);
        $data['kode_slug'] = Str::slug($request->nama_alat);

        try {
            DB::beginTransaction(); // Gunakan transaction agar data konsisten

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/alat'), $filename);
                $data['path_foto'] = 'uploads/alat/' . $filename;
            }

            $alat = Alat::create($data);

            // Simpan isi bundle jika jenisnya bundel
            if ($request->jenis_item == 'bundel' && $request->bundel) {

                foreach ($request->bundel as $item) {

                    if (!empty($item['nama_alat'])) {

                        // 🔹 Simpan ke tabel alat dulu
                        $alatItem = \App\Models\Alat::create([
                            'nama_alat' => $item['nama_alat'],
                            'harga'     => $item['harga'] ?? 0,
                            'jenis_item' => 'single' // atau default
                        ]);

                        // 🔹 Simpan ke bundel_alat
                        DB::table('bundel_alat')->insert([
                            'id_bundle' => $alat->id,
                            'id_alat'   => $alatItem->id,
                            'jumlah'    => $item['jumlah'] ?? 1,
                        ]);
                    }
                }
            }

            $this->logAktivitas('Buat', 'Alat', "Alat {$alat->nama_alat} ditambahkan");

            DB::commit();
            return redirect()->route('Alat.index')->with('success', 'Alat berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $allAlat = Alat::where('jenis_item', '!=', 'bundel')->get();
        $lokasis = \App\Models\Lokasi::all();

        return view('Alat.create', compact('kategoris', 'alat', 'allAlat', 'lokasis'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'id_kategori' => 'nullable|exists:kategori,id',
            'jenis_item' => 'required|in:bundel,single,bundel_alat',
            'maksimal_poin_pelanggaran' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'harga' => 'nullable|numeric',
            'id_lokasi' => 'nullable|exists:lokasi,id',
        ]);

        $data = $request->only([
            'id_kategori',
            'nama_alat',
            'jenis_item',
            'maksimal_poin_pelanggaran',
            'deskripsi',
            'harga',
            'id_lokasi'
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
        if ($request->jenis_item == 'bundel' && $request->bundel) {

            foreach ($request->bundel as $item) {

                if (!empty($item['nama_alat'])) {

                    // 🔹 Simpan ke tabel alat dulu
                    $alatItem = \App\Models\Alat::create([
                        'nama_alat' => $item['nama_alat'],
                        'harga'     => $item['harga'] ?? 0,
                        'jenis_item' => 'single' // atau default
                    ]);

                    // 🔹 Simpan ke bundel_alat
                    DB::table('bundel_alat')->insert([
                        'id_bundle' => $alat->id,
                        'id_alat'   => $alatItem->id,
                        'jumlah'    => $item['jumlah'] ?? 1,
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

        DB::beginTransaction();

        try {
            // 🔹 1. Ambil semua id_alat yang ada di bundel ini
            $bundelItems = DB::table('bundel_alat')
                ->where('id_bundle', $alat->id)
                ->pluck('id_alat');

            // 🔹 2. Hapus relasi bundel (yang menunjuk ke alat ini)
            DB::table('bundel_alat')
                ->where('id_bundle', $alat->id)
                ->orWhere('id_alat', $alat->id)
                ->delete();

            // 🔹 3. Hapus alat hasil generate dari bundel
            if ($bundelItems->count()) {
                Alat::whereIn('id', $bundelItems)->delete();
            }

            // 🔹 4. Hapus foto
            if ($alat->path_foto && File::exists(public_path($alat->path_foto))) {
                File::delete(public_path($alat->path_foto));
            }

            // 🔹 5. Hapus alat utama
            $alat->delete();

            $this->logAktivitas('Hapus', 'Alat', "Alat {$nama} dihapus");

            DB::commit();

            return redirect()->route('Alat.index')->with('success', 'Alat berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function show($id)
    {
        $alat = Alat::with('kategori', 'units')->findOrFail($id);

        // ambil isi bundel dengan join ke tabel alat
        $bundel = DB::table('bundel_alat')
            ->leftJoin('alat', 'bundel_alat.id_alat', '=', 'alat.id')
            ->where('bundel_alat.id_bundle', $id)
            ->select('bundel_alat.*', 'alat.nama_alat')
            ->get();

        return view('Alat.detail', compact('alat', 'bundel'));
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
