<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/files', [FilesController::class, 'index'])->name('files.index');
    Route::get('/files/create', [FilesController::class, 'create'])->name('files.create');
    Route::post('/files', [FilesController::class, 'store'])->name('files.store');
    Route::get('/files/{file}', [FilesController::class, 'show'])->name('files.show');
    Route::get('/files/{file}/edit', [FilesController::class, 'edit'])->name('files.edit');
    Route::put('/files/{file}', [FilesController::class, 'update'])->name('files.update');
    Route::get('/files/{file}/download', [FilesController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FilesController::class, 'destroy'])->name('files.destroy');
}); 

Route::get('/dashboard', [FilesController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
