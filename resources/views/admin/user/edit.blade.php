@extends('admin.layout.master-navbar')
          @section('tittle', 'Edit User')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Data User</h3>
                <p class="text-subtitle text-muted">Silahkan isi data user yang ingin diubah </p>
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
                <form class="form" action="{{route('user.update', $user->id)}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                <div class="form body">
        <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basicInput">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required value="{{ $user->username }} ">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                            <small><a href="#" class="toggle-password" data-target="#password">Tampilkan Password</a></small>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Enter password" name="password_confirmation">
                            <small><a href="#" class="toggle-password" data-target="#password_confirmation">Tampilkan Password</a></small>
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Full Name</label>
                            <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" required value="{{ $user->fullname }} ">
                        </div>


                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="basicInput">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required value="{{ $user->email }} ">
                        </div>

                         <div class="form-group">
                            <label for="basicInput">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="Enter phone number" name="phone" required value="{{ $user->phone }} ">
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Perangkat Daerah</label>
                            <select name="id_perangkat_daerah" class="form-control">
                                @foreach ($perangkatDaerah as $pd)
                                    <option value="{{ $pd->id }}" {{ old('id_perangkat_daerah', $user->id_perangkat_daerah ?? '') == $pd->id ? 'selected' : '' }}>
                                        {{ $pd->perangkat_daerah }}
                                    </option>
                                @endforeach
                            </select>

                    </div>
                        <div class="form-group">
                            <label for="staticInput">Role</label>
                            <select name="role_id" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                        {{ $role->role_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        {{-- <div class="form-group">
                            <label for="staticInput">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="staticInput" >Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" value="{{ $user->foto }}">
                        </div> --}}
                        </div>
                     <div class="form-group d-flex justify-content-end">
                            <a href="{{route('user.index')}}" type="submit" class="btn btn-danger me-1 mb-1">Batal</a>
                             <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
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
