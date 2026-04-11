<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'pengembalian';
    protected $fillable = ['id_peminjaman', 'id_petugas', 'tanggal_kembali'];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }
}
