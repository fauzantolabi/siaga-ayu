<?php

use App\Http\Controllers\{
    DashboardController,
    SuratController,
    AgendaController,
    PerangkatDaerahController,
    JabatanController,
    PakaianController,
    RoleController,
    UserController,
    ProgramController,
    MisiController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ===========================
// 🔒 Semua route yang butuh login
// ===========================
Route::middleware(['auth'])->group(function () {

    // Dashboard - bisa diakses semua user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile user
    Route::get('/profile/show', 'App\Http\Controllers\ProfileUserController@show')->name('profile.show');
    Route::get('/profile/edit', 'App\Http\Controllers\ProfileUserController@edit')->name('profile.edit');
    Route::put('/profile', 'App\Http\Controllers\ProfileUserController@update')->name('profile.update');

    // ===========================
    // 👥 Admin & User
    // ===========================
    Route::middleware('role:Admin,User')->group(function () {
        // CRUD Surat & Agenda
        Route::resource('surat', SuratController::class);
        Route::resource('agenda', AgendaController::class);

        // Tambah agenda dari surat
        Route::get('/agenda/create/{surat}', [AgendaController::class, 'createBySurat'])
            ->name('agenda.createBySurat');

        // 🔹 Dropdown dinamis untuk Jabatan (HANYA SATU ROUTE)
        Route::get('/get-jabatan/{id}', [AgendaController::class, 'getJabatan'])
            ->name('getJabatan.byPerangkatDaerah');

        // 🔹 Dropdown dinamis untuk Program berdasarkan Misi
        Route::get('/get-programs/{misi}', [AgendaController::class, 'getProgramsByMisi'])
            ->name('programs.byMisi');

        // CRUD Jabatan
        Route::resource('jabatan', JabatanController::class);
    });

    // ===========================
    // 🛠️ Admin Only
    // ===========================
    Route::middleware('role:Admin')->group(function () {
        Route::resources([
            'perangkat_daerah' => PerangkatDaerahController::class,
            'pakaian' => PakaianController::class,
            'role' => RoleController::class,
            'user' => UserController::class,
            'program' => ProgramController::class,
            'misi' => MisiController::class,
        ]);
    });
});
