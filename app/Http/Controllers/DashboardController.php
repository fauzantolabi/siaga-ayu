<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Jabatan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');

        // Ambil tanggal dari request, default ke hari ini
        $selectedDate = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))
            : Carbon::today();

        // Statistik umum
        $totalAgenda = Agenda::count();
        $totalPejabat = Jabatan::count();
        $agendaHariIni = Agenda::whereDate('tanggal', Carbon::today())->count();
        $agendaMingguIni = Agenda::whereBetween('tanggal', [
            Carbon::today(),
            Carbon::today()->copy()->addDays(7)
        ])->count();
        $agendaBulanIni = Agenda::whereMonth('tanggal', Carbon::today()->month)->count();

        // Ambil agenda berdasarkan tanggal yang dipilih
        $todayAgendas = Agenda::with(['jabatan', 'pakaian', 'surat'])
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('id_jabatan')
            ->orderBy('waktu')
            ->get()
            ->groupBy('id_jabatan');

        return view('admin.dashboard', compact(
            'totalAgenda',
            'totalPejabat',
            'agendaHariIni',
            'agendaMingguIni',
            'todayAgendas',
            'agendaBulanIni',
            'selectedDate'
        ));
    }
}
