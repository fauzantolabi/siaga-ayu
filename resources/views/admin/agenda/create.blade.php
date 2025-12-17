@extends('admin.layout.master-navbar')
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

          {{-- Asal Surat --}}
          <div class="form-group mb-3">
            <label for="id_surat">Asal Surat</label>
            @if(request('surat_id') && isset($selectedSurat))
              {{-- ✅ READONLY - Jika dari link "Buat Agenda" --}}
              <input type="text" class="form-control"
                     value="{{ $selectedSurat->nomor_surat }} - {{ $selectedSurat->asal_surat }}" readonly>
              <input type="hidden" name="id_surat" value="{{ $selectedSurat->id }}">
              <small class="text-muted">
                <i class="bi bi-info-circle"></i> Surat otomatis dipilih dari halaman daftar surat.
              </small>
            @elseif(Auth::user()->role->role_name === 'User' && isset($selectedSurat))
              {{-- User dengan surat yang dipilih dari index --}}
              <input type="text" class="form-control"
                     value="{{ $selectedSurat->nomor_surat }} - {{ $selectedSurat->asal_surat }}" readonly>
              <input type="hidden" name="id_surat" value="{{ $selectedSurat->id }}">
            @else
              {{-- Dropdown normal - Hanya jika akses langsung /agenda/create --}}
              <select name="id_surat" id="id_surat" class="form-control" required>
                <option value="">-- Pilih Surat --</option>
                @foreach($surats as $s)
                  <option value="{{ $s->id }}" {{ old('id_surat') == $s->id ? 'selected' : '' }}>
                    {{ $s->nomor_surat }} - {{ $s->asal_surat }}
                  </option>
                @endforeach
              </select>
            @endif
          </div>

          {{-- Nama Agenda --}}
          <div class="form-group mb-3">
            <label for="agenda">Nama Agenda</label>
            <input type="text" name="agenda" id="agenda" class="form-control"
                   value="{{ old('agenda') }}" required>
          </div>

          {{-- Tanggal --}}
          <div class="form-group mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="text" name="tanggal" id="tanggal"
                   class="form-control flatpickr-no-config"
                   value="{{ old('tanggal') }}" autocomplete="off" required>
          </div>

          {{-- Waktu --}}
          <div class="form-group mb-3">
            <label for="waktu">Waktu</label>
            <input type="text" name="waktu" id="waktu"
                   class="form-control flatpickr-time-picker-24h"
                   value="{{ old('waktu') }}" required>
          </div>

          {{-- Perangkat Daerah --}}
          <div class="form-group mb-3">
            <label for="id_perangkat_daerah">Perangkat Daerah</label>
            @if(Auth::user()->role->role_name === 'User')
              <input type="text" class="form-control"
                     value="{{ Auth::user()->perangkatDaerah->singkatan }}" readonly>
              <input type="hidden" name="id_perangkat_daerah" id="id_perangkat_daerah"
                     value="{{ Auth::user()->id_perangkat_daerah }}">
            @else
              <select name="id_perangkat_daerah" id="id_perangkat_daerah" class="form-control" required>
                <option value="">-- Pilih Perangkat Daerah --</option>
                @foreach($perangkatDaerah as $pd)
                  <option value="{{ $pd->id }}" {{ old('id_perangkat_daerah') == $pd->id ? 'selected' : '' }}>
                    {{ $pd->singkatan }}
                  </option>
                @endforeach
              </select>
            @endif
          </div>

          {{-- Jabatan (Multiple) --}}
          <div class="form-group mb-3">
            <label for="id_jabatans">Jabatan <span class="text-danger">*Bisa pilih lebih dari satu</span></label>
            <select name="id_jabatans[]" id="id_jabatans" class="form-control" multiple required>
              <option value="" disabled>-- Pilih Jabatan --</option>
              @foreach($jabatans as $jabatan)
                <option value="{{ $jabatan->id }}"
                  @if(is_array(old('id_jabatans')) && in_array($jabatan->id, old('id_jabatans'))) selected @endif>
                  {{ $jabatan->jabatan }}
                </option>
              @endforeach
            </select>
            <small class="text-muted d-block mt-2">
              <i class="bi bi-info-circle"></i> Gunakan Ctrl+Click (atau Cmd+Click di Mac) untuk memilih lebih dari satu jabatan
            </small>
          </div>

        </div>

        <div class="col-md-6">

          {{-- Tempat --}}
          <div class="form-group mb-3">
            <label for="tempat">Tempat</label>
            <input type="text" name="tempat" id="tempat" class="form-control"
                   value="{{ old('tempat') }}" required>
          </div>

          {{-- Pakaian --}}
          <div class="form-group mb-3">
            <label for="id_pakaian">Pakaian</label>
            <select name="id_pakaian" id="id_pakaian" class="form-control">
              <option value="">-- Pilih Pakaian --</option>
              @foreach($pakaian as $p)
                <option value="{{ $p->id }}" {{ old('id_pakaian') == $p->id ? 'selected' : '' }}>
                  {{ $p->pakaian }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Misi --}}
          <div class="form-group mb-3">
            <label for="id_misi">Misi</label>
            <select name="id_misi" id="id_misi" class="form-control" required>
              <option value="">-- Pilih Misi --</option>
              @foreach($misis as $misi)
                <option value="{{ $misi->id }}" {{ old('id_misi') == $misi->id ? 'selected' : '' }}>
                  {{ $misi->misi }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Program --}}
          <div class="form-group mb-3">
            <label for="id_program">Program</label>
            <select name="id_program" id="id_program" class="form-control" required>
              <option value="">-- Pilih Program --</option>
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
@endsection

@section('scripts')
{{-- Flatpickr CSS & JS --}}
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
<script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>

<script>
$(document).ready(function() {
    console.log('🚀 Agenda Create Script Loaded');

    // ==========================================
    // FLATPICKR INITIALIZATION
    // ==========================================
    flatpickr(".flatpickr-no-config", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y"
    });

    flatpickr(".flatpickr-time-picker-24h", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    // ==========================================
    // DEPENDENT DROPDOWN: JABATAN (Multiple Select)
    // ==========================================
    function loadJabatan(perangkatId) {
        const $jabatanSelect = $('#id_jabatans');
        console.log('📍 Loading Jabatan for Perangkat Daerah ID:', perangkatId);

        $jabatanSelect.html('<option value="" disabled>Memuat data jabatan...</option>').prop('disabled', true);

        if (!perangkatId) {
            $jabatanSelect.html('<option value="" disabled>-- Pilih Jabatan --</option>').prop('disabled', false);
            return;
        }

        $.ajax({
            url: "{{ url('/get-jabatan') }}/" + perangkatId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('✅ Jabatan Data Received:', data);
                $jabatanSelect.empty().prop('disabled', false);
                $jabatanSelect.append('<option value="" disabled>-- Pilih Jabatan --</option>');

                if (data.length > 0) {
                    $.each(data, function(index, jabatan) {
                        $jabatanSelect.append($('<option>', {
                            value: jabatan.id,
                            text: jabatan.jabatan
                        }));
                    });
                } else {
                    $jabatanSelect.append('<option value="" disabled>Tidak ada jabatan tersedia</option>');
                }

                @if(old('id_jabatans'))
                    $jabatanSelect.val({!! json_encode((array)old('id_jabatans')) !!});
                @endif
            },
            error: function(xhr, status, error) {
                console.error('❌ Error loading jabatan:', error);
                $jabatanSelect.html('<option value="" disabled>Gagal memuat jabatan</option>').prop('disabled', false);
            }
        });
    }

    $('#id_perangkat_daerah').on('change', function() {
        loadJabatan($(this).val());
    });

    @if(Auth::user()->role->role_name === 'User')
        const userPerangkatId = $('#id_perangkat_daerah').val();
        if (userPerangkatId) {
            setTimeout(function() { loadJabatan(userPerangkatId); }, 300);
        }
    @endif

    @if(old('id_perangkat_daerah') && Auth::user()->role->role_name !== 'User')
        setTimeout(function() { loadJabatan('{{ old("id_perangkat_daerah") }}'); }, 300);
    @endif

    // ==========================================
    // DEPENDENT DROPDOWN: PROGRAM
    // ==========================================
    function loadProgram(misiId) {
        const $programSelect = $('#id_program');
        console.log('📍 Loading Program for Misi ID:', misiId);

        $programSelect.html('<option value="">Memuat data program...</option>').prop('disabled', true);

        if (!misiId) {
            $programSelect.html('<option value="">-- Pilih Program --</option>').prop('disabled', false);
            return;
        }

        $.ajax({
            url: "{{ url('/get-programs') }}/" + misiId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('✅ Program Data Received:', data);
                $programSelect.empty().prop('disabled', false);
                $programSelect.append('<option value="">-- Pilih Program --</option>');

                if (data.length > 0) {
                    $.each(data, function(index, program) {
                        $programSelect.append($('<option>', {
                            value: program.id,
                            text: program.description
                        }));
                    });
                } else {
                    $programSelect.append('<option value="">Tidak ada program tersedia</option>');
                }

                @if(old('id_program'))
                    $programSelect.val('{{ old("id_program") }}');
                @endif
            },
            error: function(xhr, status, error) {
                console.error('❌ Error loading program:', error);
                $programSelect.html('<option value="">Gagal memuat program</option>').prop('disabled', false);
            }
        });
    }

    $('#id_misi').on('change', function() {
        loadProgram($(this).val());
    });

    @if(old('id_misi'))
        setTimeout(function() { loadProgram('{{ old("id_misi") }}'); }, 300);
    @endif

    console.log('✅ All event listeners registered');
});
</script>
@endsection
