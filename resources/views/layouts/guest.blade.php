<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - SIRA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #4F46E5;
            --primary-light: #6366F1;
            --primary-dark: #3730A3;
            --danger: #EF4444;
            --danger-light: #FEE2E2;
            --success: #10B981;
            --success-light: #D1FAE5;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 50%, #312E81 100%);
            color: var(--gray-800);
        }

        a { text-decoration: none; color: inherit; }

        /* Left Side - Brand */
        .auth-brand {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
            top: 20%;
            left: 10%;
            border-radius: 50%;
        }

        .auth-brand::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, transparent 70%);
            bottom: 10%;
            right: 15%;
            border-radius: 50%;
        }

        .auth-brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 440px;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, #0EA5E9 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            margin: 0 auto 28px;
            box-shadow: 0 8px 32px rgba(79, 70, 229, 0.4);
        }

        .auth-brand-content h1 {
            font-size: 40px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 12px;
        }

        .auth-brand-content p {
            font-size: 16px;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
        }

        .brand-features {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: left;
        }

        .brand-feature {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            color: rgba(255,255,255,0.7);
        }

        .brand-feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            color: rgba(255,255,255,0.8);
        }

        /* Right Side - Form */
        .auth-form-wrapper {
            width: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4);
        }

        .auth-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 4px;
        }

        .auth-card .auth-subtitle {
            font-size: 14px;
            color: var(--gray-500);
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-800);
            transition: all 0.2s ease;
            background: var(--gray-50);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            background: #fff;
        }

        .form-input.is-invalid {
            border-color: var(--danger);
        }

        .form-error {
            font-size: 13px;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-800);
            transition: all 0.2s ease;
            background: var(--gray-50);
            resize: vertical;
            min-height: 80px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            background: #fff;
        }

        .btn-auth {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .btn-auth:hover {
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.5);
            transform: translateY(-1px);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--gray-500);
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .alert-success { background: var(--success-light); color: #065F46; border: 1px solid #A7F3D0; }
        .alert-error { background: var(--danger-light); color: #991B1B; border: 1px solid #FECACA; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .remember-row label {
            font-size: 14px;
            color: var(--gray-600);
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 960px) {
            body { flex-direction: column; }

            .auth-brand {
                padding: 40px 24px;
                min-height: auto;
            }

            .auth-brand-content h1 { font-size: 28px; }
            .brand-features { display: none; }

            .auth-form-wrapper {
                width: 100%;
                padding: 24px;
            }
        }

        @media (max-width: 480px) {
            .auth-card { padding: 28px 20px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Brand Side -->
    <div class="auth-brand">
        <div class="auth-brand-content">
            <img src="{{ asset('logo.png') }}" alt="SIRA Logo" style="width: 64px; height: 64px; object-fit: contain; margin-bottom: 24px; border-radius: 16px;">
            <h1>SIRA</h1>
            <p>Sistem Informasi & Pelaporan RT/RW untuk digitalisasi layanan warga yang transparan dan terorganisir.</p>

            <div class="brand-features">
                <div class="brand-feature">
                    <div class="brand-feature-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <span>Pengajuan surat pengantar secara online</span>
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-icon"><i class="fas fa-bullhorn"></i></div>
                    <span>Laporan pengaduan dengan bukti foto</span>
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <span>Pencatatan iuran bulanan transparan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-form-wrapper">
        <div class="auth-card">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
