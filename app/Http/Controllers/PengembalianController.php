<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\KondisiUnit;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.alat',
            'petugas',
            'kondisiUnit',
            'pelanggaran'
        ])->latest()->get();

        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create(Request $request)
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->with(['user', 'alat'])->get();

        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'  => 'required|exists:peminjaman,id',
            'tanggal_kembali' => 'required|date',
            'bukti'          => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $file = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti'), $filename);

        Pengembalian::create([
            'id_peminjaman'  => $request->id_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'bukti'          => 'uploads/bukti/' . $filename,
            'status'         => 'menunggu'
        ]);

        // Ubah status peminjaman menjadi "menunggu_pengembalian" agar tombol tidak muncul lagi
        Peminjaman::where('id', $request->id_peminjaman)
            ->update(['status' => 'menunggu_pengembalian']);

        return back()->with('success', 'Pengajuan pengembalian berhasil dikirim, menunggu konfirmasi petugas.');
    }

    public function proses(Request $request, $id)
    {
        $request->validate([
            'kondisi'               => 'required_if:aksi,setujui',
            'tanggal_kembali' => 'required_if:aksi,setujui|date',
        ]);

        $pengembalian = Pengembalian::with('peminjaman.user')->findOrFail($id);
        $peminjaman   = $pengembalian->peminjaman;

        if ($request->aksi == 'setujui') {

            // Update tanggal kembali aktual yang diinput petugas
            $pengembalian->tanggal_kembali = $request->tanggal_kembali;
            $pengembalian->status          = 'disetujui';

            // Simpan kondisi barang
            KondisiUnit::create([
                'id_pengembalian' => $id,
                'kondisi'         => $request->kondisi,
                'catatan'         => $request->catatan,
            ]);

            // Update status peminjaman
            $peminjaman->update(['status' => 'dikembalikan']);

            $tanggalKembali = \Carbon\Carbon::parse($request->tanggal_kembali);
            $jatuhTempo     = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            // hitung keterlambatan
            $hariTerlambat = $jatuhTempo->diffInDays($tanggalKembali, false);
            $hariTerlambat = max(0, $hariTerlambat);

            // aturan
            $poinPerHari   = 5;
            $dendaPer5Poin = 3000;

            // hitung
            $totalPoin  = $hariTerlambat * $poinPerHari;
            $totalDenda = $hariTerlambat * 3000;

            // ✅ UPDATE ATAU CREATE
            Pelanggaran::updateOrCreate(
                ['id_pengembalian' => $id],
                [
                    'id_peminjaman'     => $peminjaman->id,
                    'id_pengguna'       => $peminjaman->id_pengguna,
                    'jenis_pelanggaran' => 'terlambat',
                    'poin'              => $totalPoin,
                    'hari_terlambat'    => $hariTerlambat,
                    'denda'             => $totalDenda,
                    'deskripsi'         => $hariTerlambat > 0
                        ? "Terlambat {$hariTerlambat} hari"
                        : "Tidak terlambat",
                    'status'            => $hariTerlambat > 0 ? 'aktif' : 'selesai',
                ]
            );

            // ✅ HANYA SEKALI
            $peminjaman->user->increment('poin_pelanggaran', $totalPoin);
        } else {
            // Ditolak — kembalikan status peminjaman agar user bisa ajukan ulang
            $pengembalian->status = 'ditolak';
            $peminjaman->update(['status' => 'dipinjam']);
        }

        $pengembalian->id_petugas = Auth::id();
        $pengembalian->save();

        return back()->with('success', 'Pengembalian berhasil diproses.');
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
