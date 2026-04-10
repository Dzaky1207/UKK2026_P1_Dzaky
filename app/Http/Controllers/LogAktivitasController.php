<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('pengguna')->latest()->get();
        return view('log_aktivitas.index', compact('logs'));
    }
}
