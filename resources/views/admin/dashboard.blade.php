@extends('admin.layout.master-navbar')
@section('tittle', 'Dashboard')

@section('content')
@php $user = Auth::user(); @endphp

<div class="page-heading mb-4">
    <h3>
        @if($user->role->role_name === 'Admin')
            Selamat Datang, Admin!
        @else
            Selamat Datang Admin {{ $user->perangkatDaerah->singkatan ?? 'Perangkat Daerah Tidak Diketahui' }}
        @endif
    </h3>
</div>

<div class="page-content">
    {{-- === NAV TAB - HANYA UNTUK ADMIN === --}}
    @if($user->role->role_name === 'Admin')
    <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="agenda-tab" data-bs-toggle="tab" data-bs-target="#agendaTab"
                    type="button" role="tab" aria-controls="agendaTab" aria-selected="true">
                🗓️ Agenda
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="statistik-tab" data-bs-toggle="tab" data-bs-target="#statistikTab"
                    type="button" role="tab" aria-controls="statistikTab" aria-selected="false">
                📊 Statistik
            </button>
        </li>
    </ul>
    @endif

    <div class="tab-content" id="dashboardTabsContent">

        {{-- ===================== 🗓️ TAB AGENDA ===================== --}}
        @if($user->role->role_name === 'Admin')
        <div class="tab-pane fade show active" id="agendaTab" role="tabpanel" aria-labelledby="agenda-tab">
        @else
        <div>
        @endif
            <section class="row">
                <div class="col-12">

                    {{-- 📊 Statistik singkat --}}
                    <div class="row">
                        @php
                            $stats = [
                                ['title' => 'Agenda Hari Ini', 'value' => $agendaHariIni, 'icon' => '📅', 'color' => 'primary'],
                                ['title' => 'Agenda Minggu Ini', 'value' => $agendaMingguIni, 'icon' => '📆', 'color' => 'success'],
                                ['title' => 'Agenda Bulan Ini', 'value' => $agendaBulanIni, 'icon' => '🗓️', 'color' => 'warning'],
                                ['title' => 'Total Agenda', 'value' => $totalAgenda, 'icon' => '📊', 'color' => 'info'],
                            ];
                        @endphp

                        @foreach($stats as $stat)
                        <div class="col-6 col-lg-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-2" style="font-size: 2rem;">{{ $stat['icon'] }}</div>
                                    <h6 class="text-muted mb-2">{{ $stat['title'] }}</h6>
                                    <h2 class="mb-0 text-{{ $stat['color'] }}">{{ $stat['value'] }}</h2>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- 📅 Filter tanggal --}}
                    <div class="card mt-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">🔍 Filter Agenda</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="text" name="tanggal" id="tanggal"
                                           class="form-control flatpickr-input"
                                           value="{{ $selectedDate->format('Y-m-d') }}" readonly>
                                </div>

                                @if($user->role->role_name === 'Admin')
                                <div class="col-md-4">
                                    <label for="id_perangkat_daerah" class="form-label">Perangkat Daerah</label>
                                    <select name="id_perangkat_daerah" id="id_perangkat_daerah" class="form-select">
                                        <option value="">Semua Perangkat Daerah</option>
                                        @foreach($perangkatDaerahs as $pd)
                                            <option value="{{ $pd->id }}" {{ $selectedPD == $pd->id ? 'selected' : '' }}>
                                                {{ $pd->singkatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="bi bi-search"></i> Tampilkan
                                    </button>
                                    <button type="button" class="btn btn-secondary me-2" id="resetFilter">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </button>
                                    <a href="{{ route('dashboard.downloadReport', request()->query()) }}" class="btn btn-success" target="_blank">
                                        <i class="bi bi-download"></i> Download PDF
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- 📋 Daftar Agenda --}}
                    <div class="card mt-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">📋 Agenda — {{ $selectedDate->translatedFormat('l, d F Y') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($todayAgendas->isEmpty())
                                <div class="alert alert-info mb-0" role="alert">
                                    <i class="bi bi-info-circle"></i> Tidak ada agenda untuk tanggal yang dipilih.
                                </div>
                            @else
                                @if($user->role->role_name === 'Admin')
                                    {{-- UNTUK ADMIN: Group by Perangkat Daerah --}}
                                    <div class="accordion" id="agendaAccordion">
                                        @foreach($todayAgendas as $pdId => $agendasByPD)
                                            @php
                                                $firstAgenda = $agendasByPD->first();
                                                $perangkatDaerahName = $firstAgenda->perangkatDaerah->perangkat_daerah ?? 'Perangkat Daerah Tidak Diketahui';
                                                $collapseId = 'collapse_pd_' . $pdId;
                                            @endphp
                                            <div class="accordion-item mb-3 border rounded">
                                                <h2 class="accordion-header" id="heading_pd_{{ $pdId }}">
                                                    <button class="accordion-button fw-bold text-uppercase"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#{{ $collapseId }}"
                                                            aria-expanded="true"
                                                            aria-controls="{{ $collapseId }}">
                                                        {{ $perangkatDaerahName }}
                                                        <span class="badge bg-secondary ms-2">{{ $agendasByPD->count() }} agenda</span>
                                                    </button>
                                                </h2>
                                                <div id="{{ $collapseId }}"
                                                     class="accordion-collapse collapse show"
                                                     aria-labelledby="heading_pd_{{ $pdId }}"
                                                     data-bs-parent="#agendaAccordion">
                                                    <div class="accordion-body">
                                                        @foreach($agendasByPD as $agenda)
                                                            <div class="card mb-2">
                                                                <div class="card-header bg-light">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span class="badge bg-primary me-2">{{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }}</span>
                                                                            <strong>{{ $agenda->agenda }}</strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body py-2">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-2">
                                                                                <strong>Pejabat:</strong>
                                                                                <div>
                                                                                    @foreach($agenda->jabatans as $jabatan)
                                                                                        <span class="badge bg-info me-1 mb-1">{{ $jabatan->jabatan }}</span>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Tempat:</strong><br>
                                                                                <i class="bi bi-geo-alt"></i> {{ $agenda->tempat }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-2">
                                                                                <strong>Pakaian:</strong><br>
                                                                                {{ $agenda->pakaian->pakaian ?? 'Belum ditentukan' }}
                                                                            </div>
                                                                            <div class="mb-0">
                                                                                <strong>Misi/Program:</strong><br>
                                                                                {{ $agenda->misi->misi ?? '-' }} {{ $agenda->program ? '→ ' . $agenda->program->description : '' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {{-- UNTUK USER: Tampilkan agenda tanpa grouping --}}
                                    <div class="accordion" id="agendaAccordion">
                                        @foreach($todayAgendas as $groupId => $agendas)
                                            @foreach($agendas as $agenda)
                                                @php
                                                    $collapseId = 'collapse_' . $agenda->id;
                                                @endphp
                                                <div class="accordion-item mb-2 border rounded">
                                                    <h2 class="accordion-header" id="heading_{{ $agenda->id }}">
                                                        <button class="accordion-button fw-bold"
                                                                type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#{{ $collapseId }}"
                                                                aria-expanded="true"
                                                                aria-controls="{{ $collapseId }}">
                                                            <span class="badge bg-primary me-2">{{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }}</span>
                                                            {{ $agenda->agenda }}
                                                        </button>
                                                    </h2>
                                                    <div id="{{ $collapseId }}"
                                                         class="accordion-collapse collapse show"
                                                         aria-labelledby="heading_{{ $agenda->id }}"
                                                         data-bs-parent="#agendaAccordion">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-2">
                                                                        <strong>Pejabat:</strong>
                                                                        <div>
                                                                            @foreach($agenda->jabatans as $jabatan)
                                                                                <span class="badge bg-info me-1 mb-1">{{ $jabatan->jabatan }}</span>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <strong>Tempat:</strong><br>
                                                                        <i class="bi bi-geo-alt"></i> {{ $agenda->tempat }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-2">
                                                                        <strong>Pakaian:</strong><br>
                                                                        {{ $agenda->pakaian->pakaian ?? 'Belum ditentukan' }}
                                                                    </div>
                                                                    <div class="mb-0">
                                                                        <strong>Misi/Program:</strong><br>
                                                                        {{ $agenda->misi->misi ?? '-' }} {{ $agenda->program ? '→ ' . $agenda->program->description : '' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            </section>
        </div>

        {{-- ===================== 📊 TAB STATISTIK - HANYA UNTUK ADMIN ===================== --}}
        @if($user->role->role_name === 'Admin')
        <div class="tab-pane fade" id="statistikTab" role="tabpanel" aria-labelledby="statistik-tab">

            {{-- Filter Statistik --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">🔍 Filter Statistik</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                        <input type="hidden" name="active_tab" value="statistik">

                        <div class="col-md-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select">
                                @foreach(range(date('Y'), date('Y') - 5) as $t)
                                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <option value="">Semua Bulan</option>
                                @foreach(range(1, 12) as $b)
                                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-bar-chart"></i> Tampilkan
                            </button>
                            <button type="button" class="btn btn-secondary" id="resetStatistik">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Charts Row --}}
            <div class="row">
                {{-- 📈 Misi Terpopuler --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">📈 Misi Terpopuler</h5>
                            <small class="text-muted">Hover pada bar untuk melihat nama lengkap misi</small>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 400px;">
                                <canvas id="misiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 📊 Program Terpopuler --}}
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">📊 Program Terpopuler</h5>
                            <small class="text-muted">Hover pada bar untuk melihat nama lengkap program</small>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 400px;">
                                <canvas id="programChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 📆 Tren Agenda per Bulan --}}
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">📆 Tren Agenda per Bulan ({{ $tahun }})</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="agendaTrendChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
{{-- Flatpickr CSS & JS --}}
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
<script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>

{{-- Chart.js - HANYA UNTUK ADMIN --}}
@if($user->role->role_name === 'Admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endif

<script>
$(document).ready(function() {
    console.log('🚀 Dashboard Script Loaded');

    // ==========================================
    // FLATPICKR INITIALIZATION
    // ==========================================
    flatpickr("#tanggal", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ $selectedDate->format('Y-m-d') }}",
        altInput: true,
        altFormat: "d/m/Y"
    });

    // ==========================================
    // RESET BUTTONS
    // ==========================================
    $('#resetFilter').on('click', function() {
        window.location.href = "{{ route('dashboard') }}";
    });

    @if($user->role->role_name === 'Admin')
    $('#resetStatistik').on('click', function() {
        window.location.href = "{{ route('dashboard') }}?active_tab=statistik";
    });

    // ==========================================
    // TAB PERSISTENCE (Remember active tab)
    // ==========================================
    const activeTab = new URLSearchParams(window.location.search).get('active_tab');
    if (activeTab === 'statistik') {
        const statistikTab = new bootstrap.Tab(document.getElementById('statistik-tab'));
        statistikTab.show();
    }

    // Save active tab to URL when clicked
    $('#dashboardTabs button').on('click', function() {
        const tabName = $(this).attr('aria-controls') === 'statistikTab' ? 'statistik' : 'agenda';
        const url = new URL(window.location);
        url.searchParams.set('active_tab', tabName);
        window.history.pushState({}, '', url);
    });

    // ==========================================
    // CHART.JS CONFIGURATION
    // ==========================================

    // Helper function to generate random colors
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const hue = (i * 360 / count) % 360;
            colors.push(`hsl(${hue}, 70%, 60%)`);
        }
        return colors;
    }

    // Data from Laravel
    const misiLabels = @json($misiStats->pluck('misi'));
    const misiData = @json($misiStats->pluck('total_agenda'));
    const programLabels = @json($programStats->pluck('description'));
    const programData = @json($programStats->pluck('total_agenda'));
    const bulanLabels = @json($bulanLabels);
    const agendaTrendData = @json($agendaTrendData);

    console.log('📊 Chart Data Loaded:', {
        misi: misiData.length,
        program: programData.length,
        trend: agendaTrendData.length
    });

    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                padding: 16,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                displayColors: true,
                boxWidth: 15,
                boxHeight: 15
            }
        }
    };

    // ==========================================
    // MISI CHART (Horizontal Bar)
    // ==========================================
    function truncateLabel(label, maxLength = 50) {
        if (label.length <= maxLength) return label;
        return label.substring(0, maxLength) + '...';
    }

    const misiLabelsDisplay = misiLabels.map(label => truncateLabel(label));

    const misiChart = new Chart(document.getElementById('misiChart'), {
        type: 'bar',
        data: {
            labels: misiLabelsDisplay,
            datasets: [{
                label: 'Jumlah Agenda',
                data: misiData,
                backgroundColor: generateColors(misiData.length),
                borderRadius: 5
            }]
        },
        options: {
            ...commonOptions,
            indexAxis: 'y',
            layout: {
                padding: {
                    left: 20,
                    right: 20
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                y: {
                    ticks: {
                        autoSkip: false,
                        font: {
                            size: 11
                        }
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        title: function(context) {
                            return misiLabels[context[0].dataIndex];
                        },
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.x + ' agenda';
                        }
                    }
                }
            }
        }
    });

    // ==========================================
    // PROGRAM CHART (Horizontal Bar)
    // ==========================================
    const programLabelsDisplay = programLabels.map(label => truncateLabel(label));

    const programChart = new Chart(document.getElementById('programChart'), {
        type: 'bar',
        data: {
            labels: programLabelsDisplay,
            datasets: [{
                label: 'Jumlah Agenda',
                data: programData,
                backgroundColor: generateColors(programData.length),
                borderRadius: 5
            }]
        },
        options: {
            ...commonOptions,
            indexAxis: 'y',
            layout: {
                padding: {
                    left: 20,
                    right: 20
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                y: {
                    ticks: {
                        autoSkip: false,
                        font: {
                            size: 11
                        }
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        title: function(context) {
                            return programLabels[context[0].dataIndex];
                        },
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.x + ' agenda';
                        }
                    }
                }
            }
        }
    });

    // ==========================================
    // TREND CHART (Line)
    // ==========================================
    const trendChart = new Chart(document.getElementById('agendaTrendChart'), {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah Agenda',
                data: agendaTrendData,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#007bff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    console.log('✅ All charts initialized successfully');
    @endif
});
</script>

<style>
    {{-- Adjust card padding and spacing --}}
    .card {
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    .page-content {
        padding-bottom: 2rem;
    }

    {{-- Stat cards styling --}}
    .card.border-0 {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card.border-0:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
    }

    {{-- Tab content spacing --}}
    .tab-content {
        padding-top: 1rem;
    }

    {{-- Accordion styling --}}
    .accordion-button {
        padding: 0.75rem 1rem;
    }

    {{-- Table spacing --}}
    table {
        margin-bottom: 1rem;
    }
</style>

@endsection
