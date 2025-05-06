<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AbsensiController;

Route::get('/absensi/{uuid}', [AbsensiController::class, 'showForm']);
Route::post('/absensi/{uuid}', [AbsensiController::class, 'submitForm']);


use App\Http\Controllers\RapatController;
Route::get('/rapat/{id}/absensi', [RapatController::class, 'showAbsensi'])->name('rapat.absensi');
