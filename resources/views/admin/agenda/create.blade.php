@extends('admin.layout.master')
@section('tittle', 'Tambah Agenda')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tambah Data Agenda</h3>
            <p class="text-subtitle text-muted">Silahkan isi data agenda yang ingin ditambahkan</p>
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

    <form action="{{ route('agenda.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row">
        <div class="col-md-6">

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
          <div class="form-group mb-3">
            <label for="agenda">Nama Agenda</label>
            <input type="text" name="agenda" id="agenda" class="form-control" value="{{ old('agenda') }}" required>
          </div>

          {{-- Tanggal --}}
          <div class="form-group mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="text" name="tanggal" id="tanggal" class="form-control flatpickr-no-config" value="{{ old('tanggal') }}" autocomplete="off" required>
          </div>

          {{-- Waktu --}}
          <div class="form-group mb-3">
            <label for="waktu">Waktu</label>
            <input type="text" name="waktu" id="waktu" class="form-control flatpickr-time-picker-24h" value="{{ old('waktu') }}" required>
          </div>

        </div>

        <div class="col-md-6">
          {{-- Perangkat Daerah & Jabatan --}}
         <div class="form-group mt-3">
            <label for="id_perangkat_daerah">Perangkat Daerah</label>
            @if(Auth::user()->role->role_name === 'User')
                {{-- 🔒 User tidak bisa ubah perangkat daerah --}}
                <input type="text" class="form-control" value="{{ Auth::user()->perangkatDaerah->singkatan }}" readonly>
                <input type="hidden" name="id_perangkat_daerah" value="{{ Auth::user()->id_perangkat_daerah }}">
            @else
                {{-- 👨‍💼 Admin bisa pilih --}}
                <select name="id_perangkat_daerah" id="id_perangkat_daerah" class="form-control" required>
                    <option value="">-- Pilih Perangkat Daerah --</option>
                    @foreach($perangkatDaerah as $pd)
                        <option value="{{ $pd->id }}">{{ $pd->singkatan }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group mt-3">
            <label for="id_jabatan">Jabatan Disposisi Agenda</label>
            <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}">{{ $jabatan->jabatan }}</option>
                @endforeach
            </select>
        </div>

          {{-- Tempat --}}
          <div class="form-group mb-3">
            <label for="tempat">Tempat</label>
            <input type="text" name="tempat" id="tempat" class="form-control" value="{{ old('tempat') }}" required>
          </div>

          {{-- Pakaian --}}
          <div class="form-group mb-3">
            <label for="id_pakaian">Pakaian</label>
            <select name="id_pakaian" id="id_pakaian" class="form-control">
              <option value="">-- Pilih Pakaian (opsional) --</option>
              @foreach($pakaian as $p)
                <option value="{{ $p->id }}" {{ old('id_pakaian') == $p->id ? 'selected' : '' }}>{{ $p->pakaian }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('agenda.index') }}" class="btn btn-danger me-2">Batal</a>
        <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
<script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>
<script>
  flatpickr(".flatpickr-no-config", {});
  flatpickr(".flatpickr-time-picker-24h", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });

  // AJAX: ketika admin pilih perangkat daerah, ambil jabatan
  @if(Auth::user()->role->role_name === 'Admin')
  document.addEventListener('DOMContentLoaded', function () {
    const pdSelect = document.getElementById('id_perangkat_daerah');
    const jabatanSelect = document.getElementById('id_jabatan');

    if (pdSelect) {
      pdSelect.addEventListener('change', function () {
        const perangkatId = this.value;
        jabatanSelect.innerHTML = '<option value="">-- Memuat Jabatan... --</option>';

        if (!perangkatId) {
          jabatanSelect.innerHTML = '<option value="">-- Pilih Jabatan --</option>';
          return;
        }

        fetch(`/get-jabatan/${perangkatId}`)
          .then(res => res.json())
          .then(data => {
            jabatanSelect.innerHTML = '<option value="">-- Pilih Jabatan --</option>';
            data.forEach(item => {
              const op = document.createElement('option');
              op.value = item.id;
              op.textContent = item.jabatan;
              jabatanSelect.appendChild(op);
            });
          })
          .catch(err => {
            console.error(err);
            jabatanSelect.innerHTML = '<option value="">-- Pilih Jabatan --</option>';
          });
      });
    }
  });
  @endif
</script>
@endsection
