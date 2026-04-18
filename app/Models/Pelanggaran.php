<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';

    protected $fillable = [
        'id_peminjaman',
        'id_pengguna',
        'id_pengembalian',
        'jenis_pelanggaran',
        'poin',
        'hari_terlambat',
        'deskripsi',
        'status',
        'denda',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian');
    }
}