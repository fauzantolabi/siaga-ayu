<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Siaga Ayu</title>
    <link rel="shortcut icon" href="{{ asset('assets/icon/logo.png') }}" type="image/png">

    {{-- Mazer CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/auth.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
        }

        #auth {
            display: flex;
            min-height: 100vh;
        }

        #auth-left {
            flex: 1;
            background: linear-gradient(135deg, #435ebe 0%, #2d3e7e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        #auth-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            opacity: 0.3;
        }

        .auth-logo {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .auth-logo img {
            width: 180px;
            height: 180px;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.2));
            object-fit: contain;
        }

        .auth-logo h1 {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .auth-logo p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin: 0;
        }

        #auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #fff;
        }

        .auth-form-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            color: #25396f;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #ffffff;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #25396f;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1px solid #dfe3e7;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #435ebe;
            box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.15);
            outline: none;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
            cursor: pointer;
        }

        .form-check-label {
            color: #fffff;
            cursor: pointer;
            user-select: none;
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #435ebe 0%, #2d3e7e 100%);
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(67, 94, 190, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 94, 190, 0.4);
            background: linear-gradient(135deg, #364b96 0%, #1f2b5a 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background-color: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            display: none;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dfe3e7;
        }

        .divider span {
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6c757d;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        a {
            color: #435ebe;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #364b96;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            #auth {
                flex-direction: column;
            }

            #auth-left {
                min-height: 300px;
                padding: 2rem;
            }

            .auth-logo h1 {
                font-size: 2rem;
            }

            .auth-logo p {
                font-size: 1rem;
            }

            #auth-right {
                padding: 2rem;
            }

            .auth-title {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 575.98px) {
            #auth-left {
                min-height: 250px;
                padding: 1.5rem;
            }

            .auth-logo img {
                width: 120px;
                height: 120px;
                object-fit: contain;
            }

            .auth-logo h1 {
                font-size: 1.5rem;
            }

            #auth-right {
                padding: 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }
        }

        /* Dark Mode Support */
        body.theme-dark #auth-right {
            background: #1e1e2d;
        }

        body.theme-dark .auth-title {
            color: #e9ecef;
        }

        body.theme-dark .auth-subtitle {
            color: #8a8d93;
        }

        body.theme-dark .form-group label {
            color: #e9ecef;
        }

        body.theme-dark .form-control {
            background-color: #151521;
            border-color: #2e2e3e;
            color: #e9ecef;
        }

        body.theme-dark .form-control:focus {
            background-color: #151521;
            border-color: #6c7cff;
        }

        body.theme-dark .form-check-label {
            color: #8a8d93;
        }

        body.theme-dark .divider::before,
        body.theme-dark .divider::after {
            border-bottom-color: #2e2e3e;
        }

        body.theme-dark .text-muted {
            color: #8a8d93;
        }

        body.theme-dark a {
            color: #6c7cff;
        }

        body.theme-dark a:hover {
            color: #5a6de8;
        }
    </style>
</head>

<body>
    <div id="auth">
        {{-- Left Side - Illustration --}}
        <div id="auth-left">
            <div class="auth-logo">
                <img src="{{ asset('assets/icon/logo.png') }}" alt="Logo">
                <h1>Siaga Ayu</h1>
                <p>Sistem Informasi Agenda Indramayu</p>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div id="auth-right">
            <div class="auth-form-wrapper">
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in dengan username dan password Anda.</p>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email Address --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control"
                               placeholder="Masukkan email Anda"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username">
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               placeholder="Masukkan password Anda"
                               required
                               autocomplete="current-password">
                    </div>

                    {{-- Remember Me --}}
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               id="remember_me"
                               name="remember">
                        <label class="form-check-label" for="remember_me">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-primary">Log in</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/static/js/initTheme.js') }}"></script>
</body>

</html>
