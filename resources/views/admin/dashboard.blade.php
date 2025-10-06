@extends('admin.layout.master')
@section('tittle', 'Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
@php
    $user = Auth::user();
@endphp

<div class="page-heading">
    <h3>
        @if($user->role->role_name === 'Admin')
            Selamat Datang, Admin!
        @else
            {{-- Selamat Datang, {{ $user->fullname ?? 'User' }} — {{ $user->perangkatDaerah->singkatan ?? 'Perangkat Daerah Tidak Diketahui' }}! --}}
            Selamat Datang Admin {{ $user->perangkatDaerah->singkatan ?? 'Perangkat Daerah Tidak Diketahui' }}
        @endif
    </h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">

            {{-- 📊 Statistik --}}
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="card-body px-4 py-4-5">
                            <h5 class="text-muted font-semibold">Agenda Hari Ini</h5>
                            <h2 class="font-extrabold mb-0">{{ $agendaHariIni }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="card-body px-4 py-4-5">
                            <h5 class="text-muted font-semibold">Agenda Minggu Ini</h5>
                            <h2 class="font-extrabold mb-0">{{ $agendaMingguIni }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="card-body px-4 py-4-5">
                            <h5 class="text-muted font-semibold">Agenda Bulan Ini</h5>
                            <h2 class="font-extrabold mb-0">{{ $agendaBulanIni }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card text-center">
                        <div class="card-body px-4 py-4-5">
                            <h5 class="text-muted font-semibold">Total Agenda</h5>
                            <h2 class="font-extrabold mb-0">{{ $totalAgenda }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📅 Filter tanggal --}}
            <div class="card mt-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-3 flex-wrap">
                        <label for="tanggal" class="fw-semibold">Pilih Tanggal:</label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control w-auto flatpickr-input"
                            value="{{ $selectedDate->format('Y-m-d') }}" placeholder="YYYY-MM-DD" autocomplete="off" readonly>

                        {{-- 🌐 Hanya admin bisa lihat dropdown perangkat daerah --}}
                        @if($user->role->role_name === 'Admin')
                            <label for="id_perangkat_daerah" class="fw-semibold">Perangkat Daerah:</label>
                            <select name="id_perangkat_daerah" id="id_perangkat_daerah" class="form-select w-auto">
                                <option value="">Semua</option>
                                @foreach($perangkatDaerahs as $pd)
                                    <option value="{{ $pd->id }}" {{ $selectedPD == $pd->id ? 'selected' : '' }}>
                                        {{ $pd->singkatan }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        <button type="button" class="btn btn-secondary" id="reset">Reset</button>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>
                </div>
            </div>

            {{-- 📋 Agenda --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Agenda Kegiatan — {{ $selectedDate->translatedFormat('l, d F Y') }}</h5>
                </div>
                <div class="card-body">
                    @if($todayAgendas->isEmpty())
                        <p>Tidak ada agenda untuk tanggal ini.</p>
                    @else
                        <div class="accordion" id="agendaAccordion">
                            @foreach($todayAgendas as $id_jabatan => $agendas)
                                @php
                                    $jabatanNama = $agendas->first()->jabatan->jabatan ?? 'Tidak diketahui';
                                    $perangkatDaerahNama = $agendas->first()->jabatan->perangkatDaerah->perangkat_daerah ?? 'Perangkat Daerah Tidak Diketahui';
                                    $collapseId = 'collapse' . $id_jabatan;
                                @endphp

                                <div class="accordion-item mb-2 border rounded">
                                    <h2 class="accordion-header" id="heading{{ $id_jabatan }}">
                                        <button class="accordion-button fw-bold text-uppercase" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="true">
                                            {{ $jabatanNama }} - {{ $perangkatDaerahNama }}
                                        </button>
                                    </h2>
                                    <div id="{{ $collapseId }}" class="accordion-collapse collapse show"
                                        data-bs-parent="#agendaAccordion">
                                        <div class="accordion-body">
                                            @foreach($agendas as $index => $agenda)
                                                <div class="mb-3 border-bottom pb-2">
                                                    <strong>{{ $index + 1 }}).</strong><br>
                                                    Jam : {{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }} <br>
                                                    Acara : {{ $agenda->agenda }} <br>
                                                    Tempat : {{ $agenda->tempat }} <br>
                                                    Pakaian : {{ $agenda->pakaian->pakaian ?? '-' }} <br>
                                                    Asal Surat : {{ $agenda->surat->asal_surat ?? '-' }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>

{{-- JS --}}
<script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>
<script>
    flatpickr("#tanggal", {
        dateFormat: "Y-m-d",
        defaultDate: "{{ $selectedDate->format('Y-m-d') }}"
    });

    document.getElementById('reset').addEventListener('click', function() {
        window.location.href = "{{ route('dashboard') }}";
    });
</script>
@endsection
