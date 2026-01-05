<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Bogalova') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #2B2D8F;
            --primary-dark: #1B1C5E;
            --secondary-text: #5E6278;
            --primary-text: #2E2E3A;
            --bg-color: #F4F6F9;
            --success: #28C76F;
            --danger: #EA5455;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, #4a4cb8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            padding: 32px;
            text-align: center;
        }

        .logo-box {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            backdrop-filter: blur(10px);
        }

        .logo-box svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .brand-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.025em;
            margin-bottom: 4px;
        }

        .brand-tagline {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .login-body {
            padding: 32px;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 28px;
        }

        .welcome-text h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-text);
            margin-bottom: 4px;
        }

        .welcome-text p {
            font-size: 0.875rem;
            color: var(--secondary-text);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary-text);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 0.9375rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.2s ease;
            background-color: #fafbfc;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(43, 45, 143, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: 0.8125rem;
            color: var(--danger);
            margin-top: 6px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 1.5px solid #d1d5db;
            border-radius: 5px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.875rem;
            color: var(--secondary-text);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px 24px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(43, 45, 143, 0.35);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 45, 143, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            padding: 24px 32px;
            background: #fafbfc;
            border-top: 1px solid #f0f0f0;
        }

        .login-footer p {
            font-size: 0.8125rem;
            color: var(--secondary-text);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: rgba(40, 199, 111, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 199, 111, 0.2);
        }

        .alert-danger {
            background-color: rgba(234, 84, 85, 0.1);
            color: var(--danger);
            border: 1px solid rgba(234, 84, 85, 0.2);
        }

        /* Decorative elements */
        .decoration {
            position: fixed;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            pointer-events: none;
        }

        .decoration-1 {
            width: 400px;
            height: 400px;
            top: -200px;
            right: -100px;
        }

        .decoration-2 {
            width: 300px;
            height: 300px;
            bottom: -150px;
            left: -100px;
        }

        .decoration-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
        }
    </style>
</head>

<body>
    <!-- Decorative elements -->
    <div class="decoration decoration-1"></div>
    <div class="decoration decoration-2"></div>
    <div class="decoration decoration-3"></div>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <!-- <div class="logo-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div> -->
                <h1 class="brand-name">Login</h1>
                <!-- <p class="brand-tagline">Financial Dashboard Management</p> -->
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- <div class="welcome-text">
                    <h2>Selamat Datang</h2>
                    <p>Silakan masuk ke akun Anda</p>
                </div> -->

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="nama@email.com" required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required
                            autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <!-- <div class="form-check">
                            <input type="checkbox" id="remember_me" name="remember" class="form-check-input">
                            <label for="remember_me" class="form-check-label">Ingat saya</label>
                        </div> -->
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>&copy; {{ date('Y') }} AldilaGroup. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>