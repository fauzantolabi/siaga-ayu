@extends('admin.layout.master')
          @section('tittle', 'Tambah Surat')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Surat</h3>
                <p class="text-subtitle text-muted">Silahkan isi data surat yang ingin ditambahkan </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                <form class="form" action="{{route('surat.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basicInput">Pengirim Surat</label>
                            <input type="text" class="form-control" id="asal_surat" placeholder="Enter nomor surat" name="asal_surat" required>
                        </div>
                        <div class="form-group">
                            <label for="id_perangkat_daerah">Perangkat Daerah Tujuan Surat</label>
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
                        <div class="form-group">
                            <label for="nomor_surat">Nomor Surat</label>
                            <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" value="{{ old('nomor_surat') }}" required>
                            @error('nomor_surat')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>                      

                        <div class="form-group">
                            <label for="basicInput">Perihal</label>
                            <input type="text" class="form-control" id="perihal" placeholder="Enter perihal" name="perihal" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="basicInput">Tanggal Surat</label>
                            <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." readonly="readonly" name="tanggal_surat">
                        </div>
                        <div class="form-group">
                             <label for="basicInput">Tanggal Terima</label>
                             <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." readonly="readonly" name="tanggal_terima"> 
                        </div>

                         <div class="form-group">
                            <label for="staticInput">Sifat Surat</label>
                            <select class="form-select" id="sifat_surat" name="sifat_surat" required>
                                <option value="" disabled selected>Pilih Sifat Surat</option>
                                <option value="rahasia">Rahasia</option>
                                    <option value="penting">Penting</option>
                                    <option value="terbatas">Terbatas</option>
                                    <option value="biasa">Biasa/ Terbuka</option>
                            </select>
                         <div class="form-group">
                            <label for="basicInput">Isi</label>
                            <textarea class="form-control" id="isi" rows="3" placeholder="Enter isi" name="hal" required></textarea>
                        </div>


                        </div>
                     <div class="form-group d-flex justify-content-end">
                            <a href="{{route('surat.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
                             <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                    </div>

                </div>
                </div>
                </form>

            </div>
          </div>
        </div>
            <link rel="stylesheet" href="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.css') }}">
            <script src="{{ asset('assets/admin/extensions/flatpickr/flatpickr.min.js') }}"></script>
            <script>
                flatpickr(".flatpickr-no-config", {});
            </script>
                        {{-- 🔽 Script AJAX hanya aktif untuk admin --}}
                @if(Auth::user()->role->role_name === 'Admin')
                <script>
                document.getElementById('id_perangkat_daerah').addEventListener('change', function () {
                    let perangkatId = this.value;
                    let jabatanSelect = document.getElementById('id_jabatan');

                    // Kosongkan dropdown jabatan
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
