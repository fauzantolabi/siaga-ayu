@extends('admin.layout.master')
          @section('tittle', 'Tambah Jabatan')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Jabatan</h3>
                <p class="text-subtitle text-muted">Silahkan isi data jabatan yang ingin ditambahkan </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                <form class="form" action="{{route('jabatan.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="basicInput">Perangkat Daerah</label>
                            <select class="form-select" id="perangkat_daerah" name="id_perangkat_daerah" required>
                                <option value="" disabled selected>Pilih Perangkat Daerah</option>
                                @foreach($perangkat_daerah as $pd)
                                    <option value="{{ $pd->id }}">{{ $pd->perangkat_daerah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Nama Jabatan" required>
                        </div>
{{--
                        <div class="form-group">
                            <label for="basicInput">Prioritas</label>
                            <input type="text" class="form-control" id="prioritas" name="prioritas" placeholder="Prioritas Jabatan" required>
                        </div> --}}
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{route('jabatan.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
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
