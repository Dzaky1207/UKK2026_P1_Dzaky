<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'kode_unit';
    protected $keyType = 'string';
    protected $table = 'unit_alat';
    protected $fillable = ['kode_unit', 'id_alat', 'status', 'catatan'];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'kode_unit', 'kode_unit');
    }
}
