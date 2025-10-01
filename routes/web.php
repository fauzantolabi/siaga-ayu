<?php

use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;



Route::get('/', function () {
    return view('welcome');
});


// Admin Routes

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
Route::resource('agenda', App\Http\Controllers\AgendaController::class);
Route::resource('surat', App\Http\Controllers\SuratController::class);
Route::resource('perangkat_daerah', App\Http\Controllers\PerangkatDaerahController::class);
Route::resource('jabatan', App\Http\Controllers\JabatanController::class);
Route::resource('pakaian', App\Http\Controllers\PakaianController::class);
Route::resource('role', App\Http\Controllers\RoleController::class);
Route::resource('user', App\Http\Controllers\UserController::class);


