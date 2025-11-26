@extends('admin.layout.master')
          @section('tittle', 'Tambah program')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data program</h3>
                <p class="text-subtitle text-muted">Silahkan isi data program yang ingin ditambahkan </p>
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
                <form class="form" action="{{route('program.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                <div class="form body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                           <label for="misi_id">Pilih Misi</label>
            <select name="misi_id" class="form-control" required>
                <option value="">-- Pilih Misi --</option>
                @foreach($misis as $misi)
                    <option value="{{ $misi->id }}">{{ $misi->misi }} - {{$misi->description }}</option>
                @endforeach
            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Program</label>
            <textarea name="description" class="form-control" required></textarea>
            @error('description')
        <small class="text-danger">{{ $message }}</small>
    @enderror
                        </div>
{{--
                        <div class="form-group">
                            <label for="basicInput">Prioritas</label>
                            <input type="text" class="form-control" id="prioritas" name="prioritas" placeholder="Prioritas program" required>
                        </div> --}}
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{route('program.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
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
