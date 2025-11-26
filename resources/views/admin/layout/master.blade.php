@include('admin.layout.__header')

<body>
    <script src="{{ asset('assets/admin/static/js/initTheme.js') }}"></script>
    @include('admin.layout.__sidebar')
    <div id="app">
        @include('admin.layout.__sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            @include('admin.layout.__footer')
        </div>
    </div>

    {{-- Core Scripts --}}
    <script src="{{ asset('assets/admin/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/compiled/js/app.js') }}"></script>

    {{-- jQuery - WAJIB untuk AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- ApexCharts - Hanya untuk Dashboard --}}
    @if(Request::is('dashboard'))
        <script src="{{ asset('assets/admin/extensions/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/admin/static/js/pages/dashboard.js') }}"></script>
    @endif

    {{-- Custom Scripts dari setiap halaman --}}
    @yield('scripts')

</body>
</html>
