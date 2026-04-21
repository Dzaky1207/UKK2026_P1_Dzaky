<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'log_aktivitas';
    protected $fillable = ['id_pengguna', 'aksi', 'modul', 'deskripsi', 'alamat_ip'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
