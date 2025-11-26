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
    return view('welcome');
});

// ===========================
// 🔒 Semua route yang butuh login
// ===========================
Route::middleware(['auth'])->group(function () {

    // Dashboard - bisa diakses semua user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
