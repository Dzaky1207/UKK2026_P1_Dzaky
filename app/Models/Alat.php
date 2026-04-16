<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'alat';
    protected $fillable = [
        'id_kategori',
        'nama_alat',
        'jenis_item',
        'maksimal_poin_pelanggaran',
        'deskripsi',
        'kode_slug',
        'path_foto',
        'harga',
        'id_lokasi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'id_alat');
    }

    public function lokasi()
    {
        return $this->belongsTo(\App\Models\Lokasi::class, 'id_lokasi');
    }
}
