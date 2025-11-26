@extends('admin.layout.master-navbar')
          @section('tittle', 'Tambah Misi')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Misi</h3>
                <p class="text-subtitle text-muted">Silahkan isi data misi yang ingin ditambahkan </p>
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
                <form class="form" action="{{route('misi.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="basicInput">Misi</label>
                            <input type="text" class="form-control" id="misi" name="misi" placeholder="Misi" required>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Deskripsi</label>
                            {{-- <input type="text" class="form-control" id="description" name="description" placeholder="Deskripsi Misi"> --}}
                            <textarea class="form-control" id="description" rows="3" name="description" placeholder="Deskripsi Misi"></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{route('misi.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
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
