<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/proses_login', [LoginController::class, 'proses_login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::controller(PesertaController::class)->prefix('/peserta')->name('peserta')->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('.create');
        Route::post('/create', 'createPost')->name('.create');
        Route::get('{id}/update', 'update')->name('.update');
        Route::post('{id}/update', 'updatePost')->name('.update');
    });
});
