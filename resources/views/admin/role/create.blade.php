@extends('admin.layout.master')
          @section('tittle', 'Tambah Role')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Role</h3>
                <p class="text-subtitle text-muted">Silahkan isi data role yang ingin ditambahkan </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                <form class="form" action="{{route('role.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="basicInput">Role</label>
                            <input type="text" class="form-control" id="role" name="role_name" placeholder="Role" required>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Deskripsi Role">
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{route('role.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
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
