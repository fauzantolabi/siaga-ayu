@extends('admin.layout.master-navbar')
          @section('tittle', 'Edit Pakaian')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Data Pakaian</h3>
                <p class="text-subtitle text-muted">Silahkan edit data pakaian yang ingin diubah </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                @if ($errors->any())
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading">Update Error!</h5>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <form class="form" action="{{route('pakaian.update',$pakaian->id)}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="basicInput">Pakaian</label>
                            <input type="text" class="form-control" id="pakaian" name="pakaian" placeholder="Nama Pakaian" required value="{{ $pakaian->pakaian }}">
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Singkatan Pakaian</label>
                            <input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Singkatan Pakaian (Jika Ada)" value="{{ $pakaian->singkatan }}">
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
