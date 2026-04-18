<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'pengembalian';
    protected $fillable = [
        'id_peminjaman',
        'tanggal_kembali',
        'bukti',
        'status',       
        'id_petugas',
        'catatan',
        'name',
        'nama_alat',
        
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    public function kondisiUnit()
    {
        return $this->hasOne(KondisiUnit::class, 'id_pengembalian');
    }

    public function pelanggaran()
    {
        return $this->hasOne(Pelanggaran::class, 'id_pengembalian');
    }
}
