@extends('admin.layout.master')
          @section('tittle', 'Tambah Perangkat Daerah')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Perangkat Daerah</h3>
                <p class="text-subtitle text-muted">Silahkan isi data perangkat daerah yang ingin ditambahkan </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                <form class="form" action="{{route('perangkat_daerah.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="basicInput">Perangkat Daerah</label>
                            <input type="text" class="form-control" id="perangkat_daerah" name="perangkat_daerah" placeholder="Nama Perangkat Daerah" required>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Singkatan Perangkat Daerah</label>
                            <input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Singkatan Perangkat Daerah (Jika Ada)">
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{route('perangkat_daerah.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
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
