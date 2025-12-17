@extends('admin.layout.master-navbar')
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
                                <input type="text" class="form-control"
                                    value="{{ $agenda->surat ? $agenda->surat->nomor_surat . ' - ' . $agenda->surat->asal_surat : '-' }}" readonly>
                                <input type="hidden" name="id_surat" value="{{ $agenda->id_surat }}">
                            @else
                                <select name="id_surat" id="id_surat" class="form-control" required>
                                    <option value="">-- Pilih Surat --</option>
                                    @foreach($surats as $s)
                                        <option value="{{ $s->id }}" {{ $agenda->id_surat == $s->id ? 'selected' : '' }}>
                                            {{ $s->nomor_surat }} - {{ $s->asal_surat }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        {{-- Nama Agenda --}}
                        <div class="form-group mb-3">
                            <label for="agenda">Nama Agenda</label>
                            <input type="text" class="form-control" id="agenda" name="agenda"
                                value="{{ old('agenda', $agenda->agenda) }}" required>
                        </div>

                        {{-- Tanggal --}}
                        <div class="form-group mb-3">
                            <label for="tanggal">Tanggal Agenda</label>
                            <input type="text" class="form-control flatpickr-no-config" id="tanggal" name="tanggal"
                                value="{{ old('tanggal', $agenda->tanggal) }}" required autocomplete="off">
                        </div>

                        {{-- Waktu --}}
                        <div class="form-group mb-3">
                            <label for="waktu">Waktu</label>
                            <input type="text" class="form-control flatpickr-time-picker-24h" id="waktu" name="waktu"
                                value="{{ old('waktu', $agenda->waktu) }}" required autocomplete="off">
                        </div>

                        {{-- Tempat --}}
                        <div class="form-group mb-3">
                            <label for="tempat">Tempat</label>
                            <input type="text" class="form-control" id="tempat" name="tempat"
                                value="{{ old('tempat', $agenda->tempat) }}" required>
                        </div>

                        {{-- Perangkat Daerah --}}
                        <div class="form-group mb-3">
                            <label for="id_perangkat_daerah">Perangkat Daerah</label>
                            @if(Auth::user()->role->role_name === 'User')
                                <input type="text" class="form-control"
                                    value="{{ $agenda->perangkatDaerah->singkatan ?? '-' }}" readonly>
                                <input type="hidden" name="id_perangkat_daerah" value="{{ $agenda->id_perangkat_daerah }}">
                            @else
                                <select name="id_perangkat_daerah" id="id_perangkat_daerah" class="form-control" required>
                                    <option value="">-- Pilih Perangkat Daerah --</option>
                                    @foreach($perangkatDaerah as $pd)
                                        <option value="{{ $pd->id }}" {{ old('id_perangkat_daerah', $agenda->id_perangkat_daerah) == $pd->id ? 'selected' : '' }}>
                                            {{ $pd->singkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom kanan --}}
                    <div class="col-md-6">
                        {{-- Misi --}}
                        <div class="form-group mb-3">
                            <label for="id_misi">Misi</label>
                            <select name="id_misi" id="id_misi" class="form-control" required>
                                <option value="">-- Pilih Misi --</option>
                                @foreach($misis as $misi)
                                    <option value="{{ $misi->id }}" {{ old('id_misi', $agenda->id_misi) == $misi->id ? 'selected' : '' }}>
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
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('id_program', $agenda->id_program) == $program->id ? 'selected' : '' }}>
                                        {{ $program->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jabatan (Multiple) --}}
                        <div class="form-group mb-3">
                            <label for="id_jabatans">Jabatan <span class="text-danger">*Bisa pilih lebih dari satu</span></label>
                            <select name="id_jabatans[]" id="id_jabatans" class="form-select" multiple required>
                                <option value="" disabled>-- Pilih Jabatan --</option>
                                @foreach($jabatans as $j)
                                    <option value="{{ $j->id }}"
                                      @if(is_array(old('id_jabatans')) && in_array($j->id, old('id_jabatans'))) selected
                                      @elseif($agenda->jabatans->contains($j->id)) selected @endif>
                                        {{ $j->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-2">
                              <i class="bi bi-info-circle"></i> Gunakan Ctrl+Click (atau Cmd+Click di Mac) untuk memilih lebih dari satu jabatan
                            </small>
                        </div>

                        {{-- Pakaian --}}
                        <div class="form-group mb-3">
                            <label for="id_pakaian">Pakaian</label>
                            <select name="id_pakaian" id="id_pakaian" class="form-select">
                                <option value="">-- Pilih Pakaian --</option>
                                @foreach($pakaian as $p)
                                    <option value="{{ $p->id }}" {{ old('id_pakaian', $agenda->id_pakaian) == $p->id ? 'selected' : '' }}>
                                        {{ $p->pakaian }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Resume --}}
                        <div class="form-group mb-3">
                            <label for="resume">Resume</label>
                            <textarea class="form-control" id="resume" name="resume" rows="3">{{ old('resume', $agenda->resume) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Foto Lama --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Saat Ini</label>
                    @if($agenda->photos && $agenda->photos->count())
                        <div class="row">
                            @foreach($agenda->photos as $photo)
                                <div class="col-md-3 col-6 text-center mb-3">
                                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto Agenda"
                                        class="img-fluid rounded shadow-sm mb-2" style="max-height:120px; object-fit:cover;">
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
                    <small class="text-muted">Bisa pilih lebih dari satu file (JPG, JPEG, PNG, maks. 2MB)</small>
                </div>

                {{-- Tombol --}}
                <div class="form-group d-flex justify-content-end mt-4">
                    <a href="{{ route('agenda.index') }}" class="btn btn-danger me-2">Batal</a>
                    <button type="reset" class="btn btn-light-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{{-- Flatpickr CSS & JS --}}
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
<script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    console.log('🚀 Agenda Edit Script Loaded');

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
    // DEPENDENT DROPDOWN: PROGRAM BERDASARKAN MISI
    // ==========================================
    function loadProgram(misiId, selectedProgramId = null) {
        const $programSelect = $('#id_program');

        console.log('📍 Loading Program for Misi ID:', misiId);

        // Reset dropdown
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
                console.log('📊 Total Program:', data.length);

                $programSelect.empty().prop('disabled', false);
                $programSelect.append('<option value="">-- Pilih Program --</option>');

                if (data.length > 0) {
                    $.each(data, function(index, program) {
                        const isSelected = selectedProgramId && program.id == selectedProgramId ? 'selected' : '';
                        $programSelect.append(
                            `<option value="${program.id}" ${isSelected}>${program.description}</option>`
                        );
                    });
                    console.log('✅ Program options populated');
                } else {
                    $programSelect.append('<option value="">Tidak ada program tersedia</option>');
                    console.warn('⚠️ No program found for this misi');
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Error loading program:', error);
                console.error('Response:', xhr.responseText);
                $programSelect.html('<option value="">Gagal memuat program</option>').prop('disabled', false);
            }
        });
    }

    // Event listener untuk perubahan Misi
    $('#id_misi').on('change', function() {
        const misiId = $(this).val();
        console.log('🔄 Misi changed to:', misiId);
        loadProgram(misiId);
    });

    // Load program saat halaman pertama kali dimuat (untuk existing data)
    const initialMisiId = $('#id_misi').val();
    const initialProgramId = '{{ old("id_program", $agenda->id_program) }}';

    if (initialMisiId) {
        console.log('🔄 Loading initial program. Misi:', initialMisiId, 'Program:', initialProgramId);
        // Delay sedikit untuk memastikan DOM sudah ready
        setTimeout(function() {
            loadProgram(initialMisiId, initialProgramId);
        }, 300);
    }

    // ==========================================
    // DEPENDENT DROPDOWN: JABATAN BERDASARKAN PERANGKAT DAERAH
    // ==========================================
    function loadJabatan(perangkatId, selectedJabatanIds = []) {
        const $jabatanSelect = $('#id_jabatans');
        console.log('📍 Loading Jabatan for Perangkat Daerah ID:', perangkatId);
        console.log('📍 Selected Jabatan IDs:', selectedJabatanIds);

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
                        const isSelected = selectedJabatanIds.includes(jabatan.id) ? 'selected' : '';
                        $jabatanSelect.append($('<option>', {
                            value: jabatan.id,
                            text: jabatan.jabatan,
                            selected: isSelected
                        }));
                    });
                } else {
                    $jabatanSelect.append('<option value="" disabled>Tidak ada jabatan tersedia</option>');
                }

                console.log('✅ Jabatan options populated with selected values');
            },
            error: function(xhr, status, error) {
                console.error('❌ Error loading jabatan:', error);
                $jabatanSelect.html('<option value="" disabled>Gagal memuat jabatan</option>').prop('disabled', false);
            }
        });
    }

    // Event listener untuk perubahan Perangkat Daerah
    $('#id_perangkat_daerah').on('change', function() {
        const perangkatId = $(this).val();
        console.log('🔄 Perangkat Daerah changed to:', perangkatId);
        loadJabatan(perangkatId, []);
    });

    // Load jabatan saat halaman pertama kali dimuat (untuk existing data)
    const initialPerangkatId = $('#id_perangkat_daerah').val();
    const initialJabatanIds = {!! json_encode($agenda->jabatans->pluck('id')->toArray()) !!};

    if (initialPerangkatId) {
        console.log('🔄 Loading initial jabatan. Perangkat:', initialPerangkatId, 'Jabatan IDs:', initialJabatanIds);
        // Delay sedikit untuk memastikan DOM sudah ready
        setTimeout(function() {
            loadJabatan(initialPerangkatId, initialJabatanIds);
        }, 300);
    }

    console.log('✅ All event listeners registered');
});
</script>
@endsection
