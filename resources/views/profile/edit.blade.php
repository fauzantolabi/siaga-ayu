@extends('admin.layout.master-navbar')
@section('tittle', 'Edit Profil')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Profil Saya</h3>
            <p class="text-subtitle text-muted">Perbarui informasi profil Anda</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">Profil Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
                </ol>
            </nav>
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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form class="form" action="{{ route('profile.update') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Enter username" name="username" required value="{{ old('username', $user->username) }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Biarkan kosong jika tidak ingin mengubah" name="password">
                            <small><a href="#" class="toggle-password" data-target="#password">Tampilkan Password</a></small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Konfirmasi password baru" name="password_confirmation">
                            <small><a href="#" class="toggle-password" data-target="#password_confirmation">Tampilkan Password</a></small>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fullname">Nama Lengkap</label>
                            <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="fullname" placeholder="Enter full name" name="fullname" required value="{{ old('fullname', $user->fullname) }}">
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" name="email" required value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter phone number" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto Profil</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Max 2MB</small>
                            @if ($user->foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Saat Ini" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    <p class="mt-2 text-sm text-muted">Foto saat ini</p>
                                </div>
                            @endif
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group d-flex justify-content-end gap-2">
                            <a href="{{ route('profile.show') }}" type="submit" class="btn btn-danger">Batal</a>
                            <button type="reset" class="btn btn-light-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('data-target'));
            if (target.getAttribute('type') === 'password') {
                target.setAttribute('type', 'text');
                this.textContent = 'Sembunyikan Password';
            } else {
                target.setAttribute('type', 'password');
                this.textContent = 'Tampilkan Password';
            }
        });
    });
</script>
@endsection
