<?php

use App\Http\Controllers\MobilController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/manage-mobil', [MobilController::class, 'index'])->name('mobil.index');
    Route::get('/manage-mobil/{id}/edit', [MobilController::class, 'edit'])->name('mobil.edit');
    Route::get('/manage-mobil/create', [MobilController::class, 'create'])->name('mobil.create');
    Route::post('/manage-mobil', [MobilController::class, 'store'])->name('mobil.store');
    Route::patch('/manage-mobil/{mobil}', [MobilController::class, 'update'])->name('mobil.update');
    Route::delete('/manage-mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    Route::get('/pinjam-mobil', [PinjamController::class, 'index'])->name('pinjam.index');
    Route::post('/pinjam-mobil', [PinjamController::class, 'store'])->name('pinjam.store');
    Route::delete('/pinjam-mobil/{id}', [PinjamController::class, 'kembali'])->name('pinjam.kembali');
});

require __DIR__ . '/auth.php';
