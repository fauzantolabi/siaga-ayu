<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Agenda, Misi, Program, PerangkatDaerah};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Set Carbon locale ke Bahasa Indonesia
        Carbon::setLocale('id');

        $user = Auth::user();

        // === FILTER DASAR ===
        $selectedDate = $request->get('tanggal')
            ? Carbon::parse($request->get('tanggal'))
            : Carbon::today();

        $selectedPD = $request->get('id_perangkat_daerah');

        // === FILTER STATISTIK (Tahun & Bulan) ===
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan');

        // === HITUNG AGENDA ===
        $agendaQuery = Agenda::query();

        // Filter berdasarkan role
        if ($user->role->role_name === 'User') {
            // User hanya melihat agenda dari perangkat daerahnya
            $agendaQuery->whereHas('jabatans', function ($q) use ($user) {
                $q->where('id_perangkat_daerah', $user->id_perangkat_daerah);
            });
        } elseif ($selectedPD) {
            // Admin dengan filter perangkat daerah
            $agendaQuery->whereHas('jabatans', fn($q) => $q->where('id_perangkat_daerah', $selectedPD));
        }

        $agendaHariIni = (clone $agendaQuery)
            ->whereDate('tanggal', Carbon::today())
            ->count();

        $agendaMingguIni = (clone $agendaQuery)
            ->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $agendaBulanIni = (clone $agendaQuery)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $totalAgenda = (clone $agendaQuery)->count();

        // === AGENDA HARI INI (berdasarkan tanggal yang dipilih) ===
        $todayAgendasQuery = (clone $agendaQuery)
            ->with(['pakaian', 'jabatans.perangkatDaerah', 'surat', 'jabatans', 'misi', 'program', 'perangkatDaerah'])
            ->whereDate('tanggal', $selectedDate);

        // Jika Admin pusat, groupBy perangkat daerah dan urutkan berdasarkan prioritas
        if ($user->role->role_name === 'Admin') {
            $todayAgendas = $todayAgendasQuery
                ->get()
                ->sortBy(function ($agenda) {
                    return $agenda->perangkatDaerah->prioritas ?? 999;
                })
                ->groupBy(function ($agenda) {
                    return $agenda->id_perangkat_daerah;
                });
        } else {
            // User hanya lihat agenda tanpa grouping
            $todayAgendas = $todayAgendasQuery
                ->orderBy('agendas.waktu', 'asc')
                ->select('agendas.*')
                ->get()
                ->groupBy(function ($agenda) {
                    return 'user_' . $agenda->id;
                });
        }

        // === PERANGKAT DAERAH (untuk filter Admin) ===
        $perangkatDaerahs = PerangkatDaerah::orderBy('singkatan')->get();

        // === STATISTIK: Misi Terpopuler ===
        $misiStatsQuery = Misi::select('misis.id', 'misis.misi', DB::raw('COUNT(DISTINCT agendas.id) as total_agenda'))
            ->leftJoin('programs', 'programs.id_misi', '=', 'misis.id')
            ->leftJoin('agendas', 'agendas.id_program', '=', 'programs.id');

        // Filter berdasarkan role untuk statistik
        if ($user->role->role_name === 'User') {
            $misiStatsQuery->leftJoin('agenda_jabatan', 'agendas.id', '=', 'agenda_jabatan.id_agenda')
                ->leftJoin('jabatans', 'agenda_jabatan.id_jabatan', '=', 'jabatans.id')
                ->where(function ($q) use ($user) {
                    $q->where('jabatans.id_perangkat_daerah', $user->id_perangkat_daerah)
                        ->orWhereNull('agendas.id'); // Include misi without agenda
                });
        }

        // Filter berdasarkan tahun dan bulan
        if ($tahun) {
            $misiStatsQuery->where(function ($q) use ($tahun) {
                $q->whereYear('agendas.tanggal', $tahun)
                    ->orWhereNull('agendas.id');
            });
        }
        if ($bulan) {
            $misiStatsQuery->where(function ($q) use ($bulan) {
                $q->whereMonth('agendas.tanggal', $bulan)
                    ->orWhereNull('agendas.id');
            });
        }

        $misiStats = $misiStatsQuery
            ->groupBy('misis.id', 'misis.misi')
            ->having('total_agenda', '>', 0) // Hanya tampilkan yang ada agendanya
            ->orderByDesc('total_agenda')
            ->take(10)
            ->get();

        // === STATISTIK: Program Terpopuler ===
        $programStatsQuery = Program::select('programs.id', 'programs.description', DB::raw('COUNT(DISTINCT agendas.id) as total_agenda'))
            ->leftJoin('agendas', 'agendas.id_program', '=', 'programs.id');

        // Filter berdasarkan role untuk statistik
        if ($user->role->role_name === 'User') {
            $programStatsQuery->leftJoin('agenda_jabatan', 'agendas.id', '=', 'agenda_jabatan.id_agenda')
                ->leftJoin('jabatans', 'agenda_jabatan.id_jabatan', '=', 'jabatans.id')
                ->where(function ($q) use ($user) {
                    $q->where('jabatans.id_perangkat_daerah', $user->id_perangkat_daerah)
                        ->orWhereNull('agendas.id'); // Include program without agenda
                });
        }

        // Filter berdasarkan tahun dan bulan
        if ($tahun) {
            $programStatsQuery->where(function ($q) use ($tahun) {
                $q->whereYear('agendas.tanggal', $tahun)
                    ->orWhereNull('agendas.id');
            });
        }
        if ($bulan) {
            $programStatsQuery->where(function ($q) use ($bulan) {
                $q->whereMonth('agendas.tanggal', $bulan)
                    ->orWhereNull('agendas.id');
            });
        }

        $programStats = $programStatsQuery
            ->groupBy('programs.id', 'programs.description')
            ->having('total_agenda', '>', 0) // Hanya tampilkan yang ada agendanya
            ->orderByDesc('total_agenda')
            ->take(10)
            ->get();

        // === TREN AGENDA PER BULAN ===
        $agendaTrendQuery = Agenda::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tanggal', $tahun);

        // Filter berdasarkan role untuk trend
        if ($user->role->role_name === 'User') {
            $agendaTrendQuery->whereHas('jabatans', function ($q) use ($user) {
                $q->where('id_perangkat_daerah', $user->id_perangkat_daerah);
            });
        }

        $agendaTrendQuery = $agendaTrendQuery
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'));

        $agendaTrendData = $agendaTrendQuery->pluck('total', 'bulan');

        // Buat label bulan dalam Bahasa Indonesia
        $bulanLabels = collect(range(1, 12))
            ->map(fn($m) => Carbon::create()->month($m)->translatedFormat('F'));

        // Map data ke 12 bulan (isi 0 jika tidak ada data)
        $agendaTrendData = collect(range(1, 12))
            ->map(fn($m) => $agendaTrendData[$m] ?? 0)
            ->values();

        // === RETURN KE VIEW ===
        return view('admin.dashboard', compact(
            'selectedDate',
            'selectedPD',
            'agendaHariIni',
            'agendaMingguIni',
            'agendaBulanIni',
            'totalAgenda',
            'todayAgendas',
            'perangkatDaerahs',
            'misiStats',
            'programStats',
            'agendaTrendData',
            'bulanLabels',
            'tahun',
            'bulan'
        ));
    }

    /**
     * Download laporan agenda dalam format PDF
     */
    public function downloadReport(Request $request)
    {
        $user = Auth::user();

        // Parse filter
        $selectedDate = $request->get('tanggal')
            ? Carbon::parse($request->get('tanggal'))
            : Carbon::today();
        $selectedPD = $request->get('id_perangkat_daerah');

        // Build query
        $agendaQuery = Agenda::query();

        if ($user->role->role_name === 'User') {
            $agendaQuery->whereHas('jabatans', function ($q) use ($user) {
                $q->where('id_perangkat_daerah', $user->id_perangkat_daerah);
            });
        } elseif ($selectedPD) {
            $agendaQuery->whereHas('jabatans', fn($q) => $q->where('id_perangkat_daerah', $selectedPD));
        }

        // Get agendas for selected date
        $agendas = $agendaQuery
            ->whereDate('tanggal', $selectedDate->format('Y-m-d'))
            ->with(['pakaian', 'jabatans.perangkatDaerah', 'surat', 'misi', 'program', 'user'])
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Group by perangkat daerah for admin
        if ($user->role->role_name === 'Admin') {
            $agendas = $agendas->groupBy('jabatans.0.perangkatDaerah.perangkat_daerah');
        }

        $html = view('admin.reports.agenda-pdf', compact(
            'agendas',
            'selectedDate',
            'user',
            'selectedPD'
        ))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4')
            ->setOrientation('portrait');

        $filename = 'Laporan-Agenda-' . $selectedDate->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
