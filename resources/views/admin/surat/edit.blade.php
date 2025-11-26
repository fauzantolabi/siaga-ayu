@extends('admin.layout.master-navbar')
@section('tittle', 'Edit Surat')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Data Surat</h3>
            <p class="text-subtitle text-muted">Silahkan ubah data surat yang diperlukan</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="form" action="{{ route('surat.update', $surat->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')

            <div class="form body">
                <div class="row">
                    {{-- Kolom kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="asal_surat">Pengirim Surat</label>
                            <input type="text" class="form-control" id="asal_surat" name="asal_surat"
                                   value="{{ old('asal_surat', $surat->asal_surat) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="id_perangkat_daerah">Perangkat Daerah Tujuan Surat</label>
                            @if(Auth::user()->role->role_name === 'User')
                                <input type="text" class="form-control"
                                       value="{{ Auth::user()->perangkatDaerah->singkatan }}" readonly>
                                <input type="hidden" name="id_perangkat_daerah"
                                       value="{{ Auth::user()->id_perangkat_daerah }}">
                            @else
                                <select name="id_perangkat_daerah" id="id_perangkat_daerah" class="form-control" required>
                                    <option value="">-- Pilih Perangkat Daerah --</option>
                                    @foreach($perangkatDaerah as $pd)
                                        <option value="{{ $pd->id }}"
                                            {{ old('id_perangkat_daerah', $surat->id_perangkat_daerah) == $pd->id ? 'selected' : '' }}>
                                            {{ $pd->singkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="id_jabatan">Jabatan Disposisi Agenda</label>
                            <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        {{ old('id_jabatan', $surat->id_jabatan) == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nomor_surat">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                                   value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="perihal">Perihal</label>
                            <input type="text" class="form-control" id="perihal" name="perihal"
                                   value="{{ old('perihal', $surat->perihal) }}" required>
                        </div>
                    </div>

                    {{-- Kolom kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_surat">Tanggal Surat</label>
                            <input type="text" class="form-control mb-3 flatpickr-no-config"
                                   name="tanggal_surat"
                                   value="{{ old('tanggal_surat', $surat->tanggal_surat) }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_terima">Tanggal Terima</label>
                            <input type="text" class="form-control mb-3 flatpickr-no-config"
                                   name="tanggal_terima"
                                   value="{{ old('tanggal_terima', $surat->tanggal_terima) }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="sifat_surat">Sifat Surat</label>
                            <select class="form-select" id="sifat_surat" name="sifat_surat" required>
                                <option value="" disabled>Pilih Sifat Surat</option>
                                <option value="rahasia" {{ old('sifat_surat', $surat->sifat_surat) == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                                <option value="penting" {{ old('sifat_surat', $surat->sifat_surat) == 'penting' ? 'selected' : '' }}>Penting</option>
                                <option value="terbatas" {{ old('sifat_surat', $surat->sifat_surat) == 'terbatas' ? 'selected' : '' }}>Terbatas</option>
                                <option value="biasa" {{ old('sifat_surat', $surat->sifat_surat) == 'biasa' ? 'selected' : '' }}>Biasa / Terbuka</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hal">Isi Surat</label>
                            <textarea class="form-control" id="hal" name="hal" rows="3" required>{{ old('hal', $surat->hal) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-end mt-4">
                        <a href="{{ route('surat.index') }}" class="btn btn-danger me-2">Batal</a>
                        <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Datepicker --}}
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
<script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>
<script>
    flatpickr(".flatpickr-no-config", {});
</script>

{{-- AJAX Jabatan --}}
@if(Auth::user()->role->role_name === 'Admin')
<script>
document.getElementById('id_perangkat_daerah').addEventListener('change', function () {
    let perangkatId = this.value;
    let jabatanSelect = document.getElementById('id_jabatan');

    jabatanSelect.innerHTML = '<option value="">-- Pilih Jabatan --</option>';

    if (perangkatId) {
        fetch(`/get-jabatan/${perangkatId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(jabatan => {
                    let option = document.createElement('option');
                    option.value = jabatan.id;
                    option.textContent = jabatan.jabatan;
                    jabatanSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching jabatan:', error));
    }
});
</script>
@endif
@endsection
