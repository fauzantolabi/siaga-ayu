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
                    {{-- Kolom kiri --}}
                    <div class="col-md-6">
                        {{-- Surat --}}
                        <div class="form-group mb-3">
        <label for="id_surat">Asal Surat</label>

        @if(Auth::user()->role->role_name === 'User')
            {{-- 🔒 User tidak bisa ubah surat --}}
            <input type="text" class="form-control" value="{{$selectedSurat->nomor_surat}} - {{ $selectedSurat->asal_surat }}" readonly>
            <input type="hidden" name="id_surat" value="{{ $selectedSurat->id }}">
        @else
            {{-- 👨‍💼 Admin bisa pilih surat --}}
            <select name="id_surat" id="id_surat" class="form-control" required>
                <option value="">-- Pilih Surat --</option>
                @foreach($surats as $s)
                    <option value="{{ $s->id }}"
                        {{ (isset($selectedSurat) && $selectedSurat && $selectedSurat->id == $s->id) ? 'selected' : '' }}>
                        {{ $s->nomor_surat }} - {{ $s->asal_surat }}
                    </option>
                @endforeach
            </select>
        @endif
    </div>

                        {{-- Nama Agenda --}}
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
                       {{-- Jabatan --}}
<div class="form-group">
    <label for="id_jabatan">Jabatan</label>
    <select name="id_jabatan" id="id_jabatan" class="form-select">
        <option value="">-- Pilih Jabatan --</option>

        @if(isset($jabatans) && $jabatans->count())
            @foreach($jabatans as $j)
                <option value="{{ $j->id }}" {{ $agenda->id_jabatan == $j->id ? 'selected' : '' }}>
                    {{ $j->jabatan }}
                </option>
            @endforeach
        @else
            {{-- fallback: tampilkan semua jika tidak ada filter (opsional) --}}
            @foreach(\App\Models\Jabatan::all() as $j)
                <option value="{{ $j->id }}" {{ $agenda->id_jabatan == $j->id ? 'selected' : '' }}>
                    {{ $j->jabatan }}
                </option>
            @endforeach
        @endif
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
                    </div>
                </div>

                <hr>

                {{-- Foto Lama --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Saat Ini</label>
                    @if(optional($agenda->photos)->count())
                        <div class="row">
                            @foreach($agenda->photos as $photo)
                                <div class="col-md-3 col-6 text-center mb-3">
                                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto Agenda" class="img-fluid rounded shadow-sm mb-2" style="max-height:120px; object-fit:cover;">
                                    <div class="form-check">
                                        <input type="checkbox" name="hapus_foto[]" value="{{ $photo->id }}" class="form-check-input" id="hapus_{{ $photo->id }}">
                                        <label for="hapus_{{ $photo->id }}" class="form-check-label small text-danger">Hapus foto ini</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada foto yang diunggah.</p>
                    @endif
                </div>

                {{-- Tambah Foto Baru --}}
                <div class="form-group">
                    <label for="fotos">Tambah Foto Baru</label>
                    <input type="file" name="fotos[]" id="fotos" class="form-control" multiple>
                    <small class="text-muted">Bisa pilih lebih dari satu file. Format: JPG, JPEG, PNG (maks. 2MB)</small>
                </div>

                {{-- Tombol --}}
                <div class="form-group d-flex justify-content-end mt-4">
                    <a href="{{ route('agenda.index') }}" class="btn btn-danger me-2">Batal</a>
                     <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Flatpickr --}}
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
