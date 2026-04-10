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
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function unitAlat()
    {
        return $this->hasMany(UnitAlat::class, 'id_alat');
    }
}
