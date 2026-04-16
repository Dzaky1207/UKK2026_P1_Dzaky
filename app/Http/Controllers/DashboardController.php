<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alat;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahAlat = Alat::count();

        return view('dashboard', compact('jumlahUser', 'jumlahAlat'));
    }
}
