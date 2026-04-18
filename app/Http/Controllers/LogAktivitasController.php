<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->latest()->get();
        return view('log_aktivitas.index', compact('logs'));
    }
}
