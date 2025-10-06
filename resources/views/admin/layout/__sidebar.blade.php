<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <h1><a href="{{ route('dashboard') }}">Siaga Ayu</a></h1>
                    <h6>Sistem Informasi Agenda Indramayu</h6>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                {{-- Dashboard --}}
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Surat --}}
                <li class="sidebar-item {{ request()->routeIs('surat.*') ? 'active' : '' }}">
                    <a href="{{ route('surat.index') }}" class='sidebar-link'>
                        <i class="bi bi-mailbox2"></i>
                        <span>Surat</span>
                    </a>
                </li>

                {{-- Agenda --}}
                <li class="sidebar-item {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                    <a href="{{ route('agenda.index') }}" class='sidebar-link'>
                        <i class="bi bi-card-list"></i>
                        <span>Agenda</span>
                    </a>
                </li>

                 <li class="sidebar-item {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                        <a href="{{ route('jabatan.index') }}" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Jabatan</span>
                        </a>
                    </li>

                {{-- Hanya tampil untuk ADMIN --}}
                @if(auth()->user() && strtolower(auth()->user()->role->role_name ?? '') === 'admin')
                    <li class="sidebar-item {{ request()->routeIs('perangkat_daerah.*') ? 'active' : '' }}">
                        <a href="{{ route('perangkat_daerah.index') }}" class='sidebar-link'>
                            <i class="bi bi-house-fill"></i>
                            <span>Perangkat Daerah</span>
                        </a>
                    </li>


                    <li class="sidebar-item {{ request()->routeIs('pakaian.*') ? 'active' : '' }}">
                        <a href="{{ route('pakaian.index') }}" class='sidebar-link'>
                            <i class="bi bi-shop"></i>
                            <span>Pakaian</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('role.*') ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}" class='sidebar-link'>
                            <i class="bi bi-window-plus"></i>
                            <span>Role</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class='sidebar-link'>
                            <i class="bi bi-person"></i>
                            <span>User</span>
                        </a>
                    </li>
                @endif

                {{-- Logout --}}
                <li class="sidebar-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                        @csrf
                        <button type="submit" class="sidebar-link btn btn-link text-start w-100">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
