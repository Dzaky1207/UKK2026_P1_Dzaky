<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahAlat = Alat::count();
        $jumlahPeminjaman = Peminjaman::count();

        return view('dashboard', compact('jumlahUser', 'jumlahAlat', 'jumlahPeminjaman'));
    }
}
