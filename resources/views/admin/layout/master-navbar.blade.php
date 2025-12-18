<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tittle') | Siaga Ayu</title>
    <link rel="shortcut icon" href="{{ asset('assets/icon/logo.png') }}" type="image/png">

    {{-- Mazer CSS --}}
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/iconly.css') }}">

    {{-- Custom CSS --}}
    <style>
        /* ========================================
           HYBRID LAYOUT - SIDEBAR + TOP NAVBAR
           ======================================== */

        body {
            font-family: 'Nunito', sans-serif;
        }

        /* Top Navbar */
        #navbar-top {
            position: fixed;
            top: 0;
            right: 0;
            left: 300px;
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
            transition: left 0.3s ease;
        }

        body.theme-dark #navbar-top {
            background: #1e1e2d;
            border-bottom-color: #2e2e3e;
        }

        /* Navbar ketika sidebar hidden */
        body.sidebar-hidden #navbar-top {
            left: 0;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #e9ecef;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        body.theme-dark #sidebar {
            background: #1e1e2d;
            border-right-color: #2e2e3e;
        }

        /* Sidebar hidden state */
        body.sidebar-hidden #sidebar {
            transform: translateX(-100%);
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        body.theme-dark .sidebar-header {
            border-bottom-color: #2e2e3e;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            flex: 1;
            min-width: 0;
        }

        .sidebar-brand-text h5 {
            margin: 0;
            color: #435ebe;
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
        }

        body.theme-dark .sidebar-brand-text h5 {
            color: #6c7cff;
        }

        .sidebar-brand-text small {
            color: #6c757d;
            font-size: 0.65rem;
            display: block;
            line-height: 1.2;
            letter-spacing: 0.3px;
        }

        body.theme-dark .sidebar-brand-text small {
            color: #8a8d93;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-title {
            padding: 0.75rem 1.5rem;
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        body.theme-dark .sidebar-title {
            color: #8a8d93;
        }

        .sidebar-item {
            margin: 0.25rem 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #6c757d;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-link i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-link span {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-link:hover {
            background-color: rgba(67, 94, 190, 0.1);
            color: #435ebe;
        }

        .sidebar-link.active {
            background-color: #435ebe;
            color: #fff;
        }

        body.theme-dark .sidebar-link {
            color: #b1b4c1;
        }

        body.theme-dark .sidebar-link:hover {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        body.theme-dark .sidebar-link.active {
            background-color: #6c7cff;
            color: #fff;
        }

        /* Submenu */
        .submenu {
            list-style: none;
            padding-left: 0;
            margin-top: 0.5rem;
            display: none;
        }

        .sidebar-item.has-submenu.active .submenu {
            display: block;
        }

        .submenu-item {
            margin: 0.25rem 0;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 1rem 0.625rem 3.5rem;
            color: #6c757d;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .submenu-link i {
            margin-right: 0.75rem;
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .submenu-link span {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .submenu-link:hover {
            background-color: rgba(67, 94, 190, 0.1);
            color: #435ebe;
        }

        .submenu-link.active {
            background-color: rgba(67, 94, 190, 0.15);
            color: #435ebe;
            font-weight: 600;
        }

        body.theme-dark .submenu-link {
            color: #b1b4c1;
        }

        body.theme-dark .submenu-link:hover {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        body.theme-dark .submenu-link.active {
            background-color: rgba(108, 124, 255, 0.2);
            color: #6c7cff;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggler {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar-toggler:hover {
            background-color: rgba(67, 94, 190, 0.1);
            color: #435ebe;
        }

        body.theme-dark .sidebar-toggler {
            color: #b1b4c1;
        }

        body.theme-dark .sidebar-toggler:hover {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        /* Navbar Right */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Theme Toggle */
        .theme-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background-color: rgba(67, 94, 190, 0.1);
            color: #435ebe;
        }

        body.theme-dark .theme-toggle {
            color: #b1b4c1;
        }

        body.theme-dark .theme-toggle:hover {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: transparent;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background-color: rgba(67, 94, 190, 0.1);
        }

        body.theme-dark .user-menu:hover {
            background-color: rgba(108, 124, 255, 0.1);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info h6 {
            margin: 0;
            font-size: 0.875rem;
            color: #25396f;
            font-weight: 600;
        }

        .user-info p {
            margin: 0;
            font-size: 0.75rem;
            color: #6c757d;
        }

        body.theme-dark .user-info h6 {
            color: #e9ecef;
        }

        body.theme-dark .user-info p {
            color: #8a8d93;
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            display: none;
            z-index: 1001;
        }

        body.theme-dark .dropdown-menu-custom {
            background: #1e1e2d;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        .dropdown-menu-custom.show {
            display: block;
        }

        .dropdown-header {
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            color: #25396f;
        }

        body.theme-dark .dropdown-header {
            border-bottom-color: #2e2e3e;
            color: #e9ecef;
        }

        .dropdown-item-custom {
            padding: 0.75rem 1.25rem;
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item-custom i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
        }

        .dropdown-item-custom span {
            display: flex;
            align-items: center;
        }

        .dropdown-item-custom:hover {
            background-color: rgba(67, 94, 190, 0.1);
            color: #435ebe;
        }

        body.theme-dark .dropdown-item-custom {
            color: #b1b4c1;
        }

        body.theme-dark .dropdown-item-custom:hover {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        /* Main Content */
        #main-content {
            margin-left: 300px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s ease;
            background-color: #f2f7ff;
        }

        body.theme-dark #main-content {
            background-color: #151521;
        }

        body.sidebar-hidden #main-content {
            margin-left: 0;
        }

        /* Footer */
        footer {
            margin-left: 300px;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e9ecef;
            transition: margin-left 0.3s ease;
            background-color: #f2f7ff;
        }

        body.theme-dark footer {
            border-top-color: #2e2e3e;
            background-color: #151521;
        }

        body.sidebar-hidden footer {
            margin-left: 0;
        }

        /* ========================================
           DARK MODE - CONTENT AREA STYLING
           ======================================== */

        /* Body Background */
        body {
            background-color: #f2f7ff;
        }

        body.theme-dark {
            background-color: #151521;
        }

        /* Page Heading */
        body.theme-dark .page-heading h3,
        body.theme-dark .page-heading h1,
        body.theme-dark .page-heading h2,
        body.theme-dark .page-heading h4,
        body.theme-dark .page-heading h5,
        body.theme-dark .page-heading h6 {
            color: #e9ecef;
        }

        body.theme-dark .page-title h3,
        body.theme-dark .page-title h1 {
            color: #e9ecef;
        }

        body.theme-dark .text-subtitle,
        body.theme-dark .text-muted {
            color: #8a8d93 !important;
        }

        /* Cards */
        body.theme-dark .card {
            background-color: #1e1e2d;
            border-color: #2e2e3e;
            color: #e9ecef;
        }

        body.theme-dark .card-header {
            background-color: #1a1a26;
            border-bottom-color: #2e2e3e;
            color: #e9ecef;
        }

        body.theme-dark .card-body {
            color: #e9ecef;
        }

        body.theme-dark .card-footer {
            background-color: #1a1a26;
            border-top-color: #2e2e3e;
        }

        /* Tables */
        body.theme-dark .table {
            color: #e9ecef;
            border-color: #2e2e3e;
        }

        body.theme-dark .table thead th {
            background-color: #1a1a26;
            color: #e9ecef;
            border-color: #2e2e3e;
        }

        body.theme-dark .table tbody tr {
            border-color: #2e2e3e;
        }

        body.theme-dark .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.02);
        }

        body.theme-dark .table-hover tbody tr:hover {
            background-color: rgba(108, 124, 255, 0.1);
        }

        /* Forms */
        body.theme-dark .form-control,
        body.theme-dark .form-select {
            background-color: #1e1e2d;
            border-color: #2e2e3e;
            color: #e9ecef;
        }

        body.theme-dark .form-control:focus,
        body.theme-dark .form-select:focus {
            background-color: #1e1e2d;
            border-color: #6c7cff;
            color: #e9ecef;
        }

        body.theme-dark .form-control::placeholder {
            color: #6c757d;
        }

        body.theme-dark .form-label {
            color: #e9ecef;
        }

        body.theme-dark .form-check-label {
            color: #e9ecef;
        }

        /* Buttons */
        body.theme-dark .btn-primary {
            background-color: #6c7cff;
            border-color: #6c7cff;
        }

        body.theme-dark .btn-primary:hover {
            background-color: #5a6de8;
            border-color: #5a6de8;
        }

        body.theme-dark .btn-secondary {
            background-color: #3e3e3e;
            border-color: #3e3e3e;
            color: #e9ecef;
        }

        body.theme-dark .btn-secondary:hover {
            background-color: #4e4e4e;
            border-color: #4e4e4e;
        }

        body.theme-dark .btn-warning {
            background-color: #ff9f43;
            border-color: #ff9f43;
        }

        body.theme-dark .btn-danger {
            background-color: #ea5455;
            border-color: #ea5455;
        }

        body.theme-dark .btn-success {
            background-color: #28c76f;
            border-color: #28c76f;
        }

        body.theme-dark .btn-info {
            background-color: #00cfe8;
            border-color: #00cfe8;
        }

        body.theme-dark .btn-light {
            background-color: #3e3e3e;
            border-color: #3e3e3e;
            color: #e9ecef;
        }

        /* Alerts */
        body.theme-dark .alert {
            border-color: #2e2e3e;
        }

        body.theme-dark .alert-success {
            background-color: rgba(40, 199, 111, 0.2);
            color: #28c76f;
            border-color: #28c76f;
        }

        body.theme-dark .alert-danger {
            background-color: rgba(234, 84, 85, 0.2);
            color: #ea5455;
            border-color: #ea5455;
        }

        body.theme-dark .alert-warning {
            background-color: rgba(255, 159, 67, 0.2);
            color: #ff9f43;
            border-color: #ff9f43;
        }

        body.theme-dark .alert-info {
            background-color: rgba(0, 207, 232, 0.2);
            color: #00cfe8;
            border-color: #00cfe8;
        }

        /* Badges */
        body.theme-dark .badge {
            color: #fff;
        }

        /* Modals */
        body.theme-dark .modal-content {
            background-color: #1e1e2d;
            color: #e9ecef;
        }

        body.theme-dark .modal-header {
            border-bottom-color: #2e2e3e;
        }

        body.theme-dark .modal-footer {
            border-top-color: #2e2e3e;
        }

        /* Breadcrumb */
        body.theme-dark .breadcrumb {
            background-color: transparent;
        }

        body.theme-dark .breadcrumb-item a {
            color: #6c7cff;
        }

        body.theme-dark .breadcrumb-item.active {
            color: #8a8d93;
        }

        /* Pagination */
        body.theme-dark .page-link {
            background-color: #1e1e2d;
            border-color: #2e2e3e;
            color: #e9ecef;
        }

        body.theme-dark .page-link:hover {
            background-color: rgba(108, 124, 255, 0.1);
            border-color: #6c7cff;
            color: #6c7cff;
        }

        body.theme-dark .page-item.active .page-link {
            background-color: #6c7cff;
            border-color: #6c7cff;
        }

        /* Accordion */
        body.theme-dark .accordion-item {
            background-color: #1e1e2d;
            border-color: #2e2e3e;
        }

        body.theme-dark .accordion-button {
            background-color: #1e1e2d;
            color: #e9ecef;
        }

        body.theme-dark .accordion-button:not(.collapsed) {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        body.theme-dark .accordion-body {
            background-color: #1e1e2d;
            color: #e9ecef;
        }

        /* Text Colors */
        body.theme-dark .text-primary {
            color: #6c7cff !important;
        }

        body.theme-dark .text-secondary {
            color: #8a8d93 !important;
        }

        body.theme-dark .text-dark {
            color: #e9ecef !important;
        }

        body.theme-dark .text-gray-600 {
            color: #8a8d93 !important;
        }

        /* Border Colors */
        body.theme-dark .border {
            border-color: #2e2e3e !important;
        }

        body.theme-dark .border-top,
        body.theme-dark .border-bottom,
        body.theme-dark .border-left,
        body.theme-dark .border-right {
            border-color: #2e2e3e !important;
        }

        /* Shadows in Dark Mode */
        body.theme-dark .shadow,
        body.theme-dark .shadow-sm,
        body.theme-dark .shadow-lg {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5) !important;
        }

        /* Nav Tabs */
        body.theme-dark .nav-tabs {
            border-bottom-color: #2e2e3e;
        }

        body.theme-dark .nav-tabs .nav-link {
            color: #8a8d93;
        }

        body.theme-dark .nav-tabs .nav-link:hover {
            border-color: #2e2e3e;
            color: #6c7cff;
        }

        body.theme-dark .nav-tabs .nav-link.active {
            background-color: #1e1e2d;
            border-color: #2e2e3e #2e2e3e #1e1e2d;
            color: #6c7cff;
        }

        body.theme-dark .tab-content {
            background-color: transparent;
        }

        /* List Group */
        body.theme-dark .list-group-item {
            background-color: #1e1e2d;
            border-color: #2e2e3e;
            color: #e9ecef;
        }

        body.theme-dark .list-group-item:hover {
            background-color: rgba(108, 124, 255, 0.1);
        }

        /* Progress Bar */
        body.theme-dark .progress {
            background-color: #2e2e3e;
        }

        /* Dropdown Menu (di content) */
        body.theme-dark .dropdown-menu {
            background-color: #1e1e2d;
            border-color: #2e2e3e;
        }

        body.theme-dark .dropdown-item {
            color: #e9ecef;
        }

        body.theme-dark .dropdown-item:hover {
            background-color: rgba(108, 124, 255, 0.1);
            color: #6c7cff;
        }

        body.theme-dark .dropdown-divider {
            border-top-color: #2e2e3e;
        }

        /* Responsive */
        @media (max-width: 1199.98px) {
            #sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-shown #sidebar {
                transform: translateX(0);
            }

            #navbar-top {
                left: 0;
            }

            #main-content,
            footer {
                margin-left: 0;
            }

            .user-info {
                display: none;
            }
        }

        /* Scrollbar Styling */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        body.theme-dark #sidebar::-webkit-scrollbar-thumb {
            background: #3e3e3e;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        @media (max-width: 1199.98px) {
            body.sidebar-shown .sidebar-overlay {
                display: block;
            }
        }
    </style>

    @yield('css')
</head>

<body>
    <script src="{{ asset('assets/admin/static/js/initTheme.js') }}"></script>

    <div id="app">
        {{-- ========== SIDEBAR ========== --}}
        <div id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <img src="{{ asset('assets/icon/logo.png') }}" alt="Logo">
                    <div class="sidebar-brand-text">
                        <h5>Siaga Ayu</h5>
                        <small>Sistem Informasi Agenda Indramayu</small>
                    </div>
                </a>
            </div>

            <div class="sidebar-menu">
                <div class="sidebar-title">Menu</div>

                {{-- Dashboard --}}
                <div class="sidebar-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                {{-- Surat, Agenda, Jabatan (hanya untuk Admin dan User, bukan Pimpinan) --}}
                @if(auth()->check() && auth()->user()->role->role_name !== 'Pimpinan')
                    {{-- Surat --}}
                    <div class="sidebar-item">
                        <a href="{{ route('surat.index') }}" class="sidebar-link {{ request()->routeIs('surat.*') ? 'active' : '' }}">
                            <i class="bi bi-mailbox2"></i>
                            <span>Surat</span>
                        </a>
                    </div>

                    {{-- Agenda --}}
                    <div class="sidebar-item">
                        <a href="{{ route('agenda.index') }}" class="sidebar-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                            <i class="bi bi-card-list"></i>
                            <span>Agenda</span>
                        </a>
                    </div>

                    {{-- Jabatan --}}
                    <div class="sidebar-item">
                        <a href="{{ route('jabatan.index') }}" class="sidebar-link {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i>
                            <span>Jabatan</span>
                        </a>
                    </div>
                @endif

                {{-- Master Data (Hanya Admin) --}}
                @if(auth()->check() && auth()->user()->role->role_name === 'Admin')
                <div class="sidebar-title">Master Data</div>

                <div class="sidebar-item">
                    <a href="{{ route('perangkat_daerah.index') }}" class="sidebar-link {{ request()->routeIs('perangkat_daerah.*') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Perangkat Daerah</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('pakaian.index') }}" class="sidebar-link {{ request()->routeIs('pakaian.*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>
                        <span>Pakaian</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('role.index') }}" class="sidebar-link {{ request()->routeIs('role.*') ? 'active' : '' }}">
                        <i class="bi bi-window-plus"></i>
                        <span>Role</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('user.index') }}" class="sidebar-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i>
                        <span>User</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('misi.index') }}" class="sidebar-link {{ request()->routeIs('misi.*') ? 'active' : '' }}">
                        <i class="bi bi-list"></i>
                        <span>Misi</span>
                    </a>
                </div>

                <div class="sidebar-item">
                    <a href="{{ route('program.index') }}" class="sidebar-link {{ request()->routeIs('program.*') ? 'active' : '' }}">
                        <i class="bi bi-list-stars"></i>
                        <span>Program</span>
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar Overlay (Mobile) --}}
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        {{-- ========== TOP NAVBAR ========== --}}
        <nav id="navbar-top">
            <button class="sidebar-toggler" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>

            <div class="navbar-right">
                {{-- Dark Mode Toggle --}}
                <button class="theme-toggle" id="theme-toggle">
                    <i class="bi bi-sun-fill theme-icon-light"></i>
                    <i class="bi bi-moon-fill theme-icon-dark" style="display: none;"></i>
                </button>

                {{-- User Dropdown --}}
                <div class="user-dropdown">
                    <button class="user-menu" onclick="toggleUserDropdown()">
                        <div class="avatar">
                            @if (Auth::user()->foto)
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar">
                            @else
                                <img src="{{ asset('assets/admin/compiled/jpg/1.jpg') }}" alt="Avatar">
                            @endif
                        </div>
                        <div class="user-info">
                            <h6>{{ Auth::user()->fullname }}</h6>
                            <p>{{ Auth::user()->role->role_name }}</p>
                        </div>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="dropdown-menu-custom" id="userDropdown">
                        <div class="dropdown-header">
                            Hello, {{ Auth::user()->fullname }}!
                        </div>
                        <a href="{{ route('profile.show') }}" class="dropdown-item-custom">
                            <i class="bi bi-person-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                        <hr style="margin: 0.5rem 0; border-color: #e9ecef;">
                        <form action="{{ route('logout') }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                            @csrf
                            <button type="submit" class="dropdown-item-custom">
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- ========== MAIN CONTENT ========== --}}
        <div id="main-content">
            @yield('content')
        </div>

        {{-- ========== FOOTER ========== --}}
        <footer>
            <div class="text-muted">
                <p class="mb-0">2025 &copy; Tim IT Diskominfo Kab. Indramayu</p>
            </div>
        </footer>
    </div>

    {{-- Core Scripts --}}
    <script src="{{ asset('assets/admin/compiled/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- ApexCharts - Hanya untuk Dashboard --}}
    @if(Request::is('dashboard'))
        <script src="{{ asset('assets/admin/extensions/apexcharts/apexcharts.min.js') }}"></script>
    @endif

    {{-- Custom Scripts --}}
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            if (window.innerWidth > 1199) {
                document.body.classList.toggle('sidebar-hidden');
                localStorage.setItem('sidebarHidden', document.body.classList.contains('sidebar-hidden'));
            } else {
                document.body.classList.toggle('sidebar-shown');
            }
        }

        // Toggle User Dropdown
        function toggleUserDropdown() {
            document.getElementById('userDropdown').classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userMenu = document.querySelector('.user-menu');

            if (!userMenu.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Dark Mode Toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const currentTheme = document.body.classList.contains('theme-dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.body.classList.remove('theme-' + currentTheme);
            document.body.classList.add('theme-' + newTheme);

            localStorage.setItem('theme', newTheme);

            // Toggle icons
            document.querySelector('.theme-icon-light').style.display = newTheme === 'dark' ? 'none' : 'inline';
            document.querySelector('.theme-icon-dark').style.display = newTheme === 'dark' ? 'inline' : 'none';
        });

        // Load saved theme
        window.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.body.classList.add('theme-' + savedTheme);

            document.querySelector('.theme-icon-light').style.display = savedTheme === 'dark' ? 'none' : 'inline';
            document.querySelector('.theme-icon-dark').style.display = savedTheme === 'dark' ? 'inline' : 'none';

            // Load sidebar state
            if (window.innerWidth > 1199) {
                const sidebarHidden = localStorage.getItem('sidebarHidden') === 'true';
                if (sidebarHidden) {
                    document.body.classList.add('sidebar-hidden');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1199) {
                document.body.classList.remove('sidebar-shown');
            }
        });
    </script>

    @yield('scripts')

</body>
</html>
