@extends('admin.layout.master')
@section('tittle', 'Edit Agenda')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Data Agenda</h3>
            <p class="text-subtitle text-muted">Silahkan ubah data agenda sesuai kebutuhan</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- Validasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form" action="{{ route('agenda.update', $agenda->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="form-body">
                <div class="row">
                    {{-- Surat --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_surat">Pilih Surat</label>
                            <select name="id_surat" id="id_surat" class="form-select" required>
                                @foreach($surat as $s)
                                    <option value="{{ $s->id }}" {{ $agenda->id_surat == $s->id ? 'selected' : '' }}>
                                        {{ $s->nomor_surat }} - {{ $s->asal_surat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Agenda --}}
                        <div class="form-group">
                            <label for="agenda">Nama Agenda</label>
                            <input type="text" class="form-control" id="agenda" name="agenda"
                                   value="{{ old('agenda', $agenda->agenda) }}" required>
                        </div>

                        {{-- Tanggal --}}
                        <div class="form-group">
                            <label for="tanggal">Tanggal Agenda</label>
                            <input type="text" class="form-control flatpickr-no-config" id="tanggal" name="tanggal"
                                   value="{{ old('tanggal', $agenda->tanggal) }}" required autocomplete="off">
                        </div>

                        {{-- Waktu --}}
                        <div class="form-group">
                            <label for="waktu">Waktu</label>
                            <input type="text" class="form-control flatpickr-time-picker-24h" id="waktu" name="waktu"
                                   value="{{ old('waktu', $agenda->waktu) }}" required autocomplete="off">
                        </div>
                    </div>

                    {{-- Kolom kanan --}}
                    <div class="col-md-6">
                        {{-- Tempat --}}
                        <div class="form-group">
                            <label for="tempat">Tempat</label>
                            <input type="text" class="form-control" id="tempat" name="tempat"
                                   value="{{ old('tempat', $agenda->tempat) }}" required>
                        </div>

                        {{-- Jabatan --}}
                        <div class="form-group">
                            <label for="id_jabatan">Jabatan</label>
                            <select name="id_jabatan" id="id_jabatan" class="form-select">
                                @foreach($jabatan as $j)
                                    <option value="{{ $j->id }}" {{ $agenda->id_jabatan == $j->id ? 'selected' : '' }}>
                                        {{ $j->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pakaian --}}
                        <div class="form-group">
                            <label for="id_pakaian">Pakaian</label>
                            <select name="id_pakaian" id="id_pakaian" class="form-select">
                                @foreach($pakaian as $p)
                                    <option value="{{ $p->id }}" {{ $agenda->id_pakaian == $p->id ? 'selected' : '' }}>
                                        {{ $p->pakaian }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Resume --}}
                        <div class="form-group">
                            <label for="resume">Resume</label>
                            <textarea class="form-control" id="resume" name="resume" rows="3">{{ old('resume', $agenda->resume) }}</textarea>
                        </div>

                        {{-- Foto --}}
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            @if($agenda->foto)
                                <p><img src="{{ asset('storage/'.$agenda->foto) }}" alt="Foto Agenda" width="120" class="mb-2"></p>
                            @endif
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="form-group d-flex justify-content-end mt-3">
                    <a href="{{ route('agenda.index') }}" class="btn btn-danger me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
        <link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
            <script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>
            <script>
                flatpickr(".flatpickr-no-config", {});
                flatpickr(".flatpickr-time-picker-24h", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
            </script>
          @endsection
