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
                            <label for="basicInput">Asal Surat</label>
                            <input type="text" class="form-control" id="asal_surat" placeholder="Enter asal surat" name="asal_surat" required>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" placeholder="Enter nomor surat" name="nomor_surat" required>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Perihal</label>
                            <input type="text" class="form-control" id="perihal" placeholder="Enter perihal" name="perihal" required>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Tanggal Surat</label>
                            <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." readonly="readonly" name="tanggal_surat">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basicInput">Tanggal Terima</label><input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." readonly="readonly" name="tanggal_terima"> </div>

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
          @endsection
