<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// untuk peminjam
Route::get('/user', [UserController::class, 'index'])->name('User.user');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');

// untuk alat
Route::get('/alat', [AlatController::class, 'index'])->name('Alat.index');
Route::get('/alat/create', [AlatController::class, 'create'])->name('Alat.create');
Route::post('/alat/store', [AlatController::class, 'store'])->name('Alat.store');
Route::get('/alat/edit/{alat}', [AlatController::class, 'edit'])->name('Alat.edit');
Route::get('/alat/show/{alat}', [AlatController::class, 'show'])->name('Alat.show');
Route::put('/alat/update/{alat}', [AlatController::class, 'update'])->name('Alat.update');
Route::delete('/alat/destroy/{alat}', [AlatController::class, 'destroy'])->name('Alat.destroy');

// untuk kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('Kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/update/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/destroy/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// untuk lokasi
Route::get('/lokasi', [LokasiController::class, 'index'])->name('Lokasi.index');
Route::get('/lokasi/create', [LokasiController::class, 'create'])->name('Lokasi.create');
Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('Lokasi.store');
Route::get('/lokasi/edit/{lokasi}', [LokasiController::class, 'edit'])->name('Lokasi.edit');
Route::put('/lokasi/update/{lokasi}', [LokasiController::class, 'update'])->name('Lokasi.update');
Route::delete('/lokasi/destroy/{lokasi}', [LokasiController::class, 'destroy'])->name('Lokasi.destroy');

// untuk log aktivitas
Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('Log_aktivitas.index');

// untuk peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('Peminjaman.index');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('Peminjaman.create');
Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('Peminjaman.store');
Route::get('/peminjaman/edit/{peminjaman}', [PeminjamanController::class, 'edit'])->name('Peminjaman.edit');
Route::put('/peminjaman/update/{peminjaman}', [PeminjamanController::class, 'update'])->name('Peminjaman.update');
Route::delete('/peminjaman/destroy/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('Peminjaman.destroy');
Route::post('/peminjaman/approve/{peminjaman}', [PeminjamanController::class, 'approve'])->name('Peminjaman.approve');
Route::post('/peminjaman/reject/{peminjaman}', [PeminjamanController::class, 'reject'])->name('Peminjaman.reject');

// untuk laporan peminjam
Route::get('/laporan/peminjam', [PeminjamanController::class, 'laporanPeminjam'])->name('Peminjaman.laporanPeminjam');
Route::get('/laporan/peminjam/{user}', [PeminjamanController::class, 'detailPeminjam'])->name('Peminjaman.detailPeminjam');
Route::get('/laporan-peminjam/export', [PeminjamanController::class, 'exportExcel'])
    ->name('Peminjaman.exportExcel');
Route::get('/laporan-peminjam/export/{user}', [PeminjamanController::class, 'exportDetailPeminjam'])
    ->name('Peminjaman.exportDetailPeminjam');

// untuk pengembalian
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('Pengembalian.index');
Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('Pengembalian.create');
Route::post('/pengembalian/store', [PengembalianController::class, 'store'])->name('Pengembalian.store');


require __DIR__ . '/auth.php';
