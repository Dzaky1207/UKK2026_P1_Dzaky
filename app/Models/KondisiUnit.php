<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KondisiUnit extends Model
{
    protected $table = 'kondisi_unit';

    protected $fillable = [
        'kode_unit',
        'id_pengembalian',
        'kondisi',
        'catatan'
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian');
    }
}
