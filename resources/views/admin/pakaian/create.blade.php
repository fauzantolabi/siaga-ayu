@extends('admin.layout.master')
          @section('tittle', 'Tambah Pakaian')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Pakaian</h3>
                <p class="text-subtitle text-muted">Silahkan isi data pakaian yang ingin ditambahkan </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                <form class="form" action="{{route('pakaian.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="basicInput">Pakaian</label>
                            <input type="text" class="form-control" id="pakaian" name="pakaian" placeholder="Nama Pakaian" required>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Singkatan Pakaian</label>
                            <input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Singkatan Pakaian (Jika Ada)">
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{route('pakaian.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
                             <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                        </div>

                    </div>
                </div>
                </div>
                </form>

            </div>
        </div>
          @endsection
