<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'peminjaman';
    protected $fillable = [
        'id_pengguna',
        'id_alat',
        'kode_unit',
        'id_petugas',
        'status',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tujuan',
        'catatan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman');
    }
}
