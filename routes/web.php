<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogAktivitasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
Route::get('/alat/create', [AlatController::class, 'create'])->name('alat.create');
Route::post('/alat/store', [AlatController::class, 'store'])->name('alat.store');
Route::get('/alat/edit/{alat}', [AlatController::class, 'edit'])->name('alat.edit');
Route::put('/alat/update/{alat}', [AlatController::class, 'update'])->name('alat.update');
Route::delete('/alat/destroy/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');

// untuk kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('Kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/update/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/destroy/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// untuk log aktivitas
Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('Log_aktivitas.index');

require __DIR__.'/auth.php';
