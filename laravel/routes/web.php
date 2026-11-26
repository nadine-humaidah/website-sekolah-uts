<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// ROUTE PROYEK SEKOLAH
// ============================================================

// 1. Dashboard sesuai role
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/guru/dashboard', function () {
        return view('guru.dashboard');
    })->middleware('role:guru')->name('guru.dashboard');

    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->middleware('role:siswa')->name('siswa.dashboard');
});

// 2. CRUD Berita
// Guest bisa lihat index & show
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');

// Hanya auth + admin/guru yang bisa create, edit, delete
Route::middleware(['auth', 'role:admin,guru'])->group(function () {
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
});

require __DIR__.'/auth.php';