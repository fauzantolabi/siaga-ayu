<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\PerangkatDaerahController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PakaianController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Surat
Route::resource('surat', SuratController::class);

// Agenda
Route::resource('agenda', AgendaController::class)->except(['create']);
Route::get('/agenda/create/{surat}', [AgendaController::class, 'createBySurat'])
    ->name('agenda.createBySurat');

// Perangkat Daerah
Route::resource('perangkat_daerah', PerangkatDaerahController::class);

// Jabatan
Route::resource('jabatan', JabatanController::class);

// Pakaian
Route::resource('pakaian', PakaianController::class);

// Role
Route::resource('role', RoleController::class);

// User
Route::resource('user', UserController::class);
