@extends('admin.layout.master-navbar')
@section('tittle', 'Profil Saya')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Profil Saya</h3>
            <p class="text-subtitle text-muted">Lihat dan kelola informasi profil Anda</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/admin/compiled/jpg/1.jpg') }}" alt="Avatar Default" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                </div>
                <h5 class="card-title">{{ $user->fullname }}</h5>
                <p class="text-muted text-sm mb-2">
                    <i class="bi bi-bag-fill"></i> {{ $user->role->role_name ?? 'N/A' }}
                </p>
                <p class="text-muted text-sm mb-3">
                    <i class="bi bi-building"></i> {{ $user->perangkatDaerah->perangkat_daerah ?? 'N/A' }}
                </p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Nama Lengkap</p>
                        <h6>{{ $user->fullname }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Username</p>
                        <h6>{{ $user->username }}</h6>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Email</p>
                        <h6>{{ $user->email }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Nomor Telepon</p>
                        <h6>{{ $user->phone ?? '-' }}</h6>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Perangkat Daerah</p>
                        <h6>{{ $user->perangkatDaerah->perangkat_daerah ?? '-' }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Role</p>
                        <h6><span class="badge bg-primary">{{ $user->role->role_name ?? '-' }}</span></h6>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tanggal Dibuat</p>
                        <h6>{{ $user->created_at->format('d M Y') }}</h6>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Terakhir Diperbarui</p>
                        <h6>{{ $user->updated_at->format('d M Y H:i') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
