<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\PerangkatDaerah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->input('tanggal')
            ? Carbon::parse($request->tanggal)
            : Carbon::today();
        $selectedPD = $request->input('id_perangkat_daerah');

        // Query dasar Agenda
        $agendaQuery = Agenda::with(['jabatan.perangkatDaerah', 'pakaian', 'surat']);

        // 🔹 Filter sesuai role user
        if ($user->role->role_name === 'User') {
            $agendaQuery->whereHas('jabatan', function ($q) use ($user) {
                $q->where('id_perangkat_daerah', $user->id_perangkat_daerah);
            });
        } elseif ($selectedPD) {
            // Admin bisa filter perangkat daerah dari dropdown
            $agendaQuery->whereHas('jabatan', function ($q) use ($selectedPD) {
                $q->where('id_perangkat_daerah', $selectedPD);
            });
        }

        // 🔹 Urutkan berdasarkan prioritas jabatan (semakin tinggi semakin dulu)
        // Pastikan di tabel jabatan ada kolom 'tingkat' atau 'prioritas' (angka makin kecil makin tinggi)
        $agendaQuery->join('jabatans', 'agendas.id_jabatan', '=', 'jabatans.id')
            ->select('agendas.*')
            ->orderBy('jabatans.prioritas', 'asc') // urutkan jabatan tertinggi dulu
            ->orderBy('agendas.tanggal', 'asc')
            ->orderBy('agendas.waktu', 'asc');

        // 📅 Ambil agenda untuk tanggal terpilih
        $todayAgendas = (clone $agendaQuery)
            ->whereDate('agendas.tanggal', $selectedDate)
            ->get()
            ->groupBy('id_jabatan');

        // 📊 Statistik
        $agendaHariIni = (clone $agendaQuery)
            ->whereDate('agendas.tanggal', Carbon::today())
            ->count();

        $agendaMingguIni = (clone $agendaQuery)
            ->whereBetween('agendas.tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count();

        $agendaBulanIni = (clone $agendaQuery)
            ->whereMonth('agendas.tanggal', Carbon::now()->month)
            ->count();

        $totalAgenda = (clone $agendaQuery)->count();

        // 🔹 Ambil perangkat daerah (hanya untuk Admin)
        $perangkatDaerahs = $user->role->role_name === 'Admin'
            ? PerangkatDaerah::orderBy('singkatan')->get()
            : collect();

        return view('admin.dashboard', compact(
            'selectedDate',
            'selectedPD',
            'todayAgendas',
            'agendaHariIni',
            'agendaMingguIni',
            'agendaBulanIni',
            'totalAgenda',
            'perangkatDaerahs'
        ));
    }
}
