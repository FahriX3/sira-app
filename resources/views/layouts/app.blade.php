<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIRA') - Sistem Informasi RT/RW</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        // Check for saved theme preference, otherwise use system preference
        const theme = localStorage.getItem('theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #4F46E5;
            --primary-light: #6366F1;
            --primary-dark: #3730A3;
            --primary-50: #EEF2FF;
            --secondary: #0EA5E9;
            --success: #10B981;
            --success-light: #D1FAE5;
            --warning: #F59E0B;
            --warning-light: #FEF3C7;
            --danger: #EF4444;
            --danger-light: #FEE2E2;
            --info: #3B82F6;
            --info-light: #DBEAFE;
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
            --sidebar-width: 272px;
            --topbar-height: 64px;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
            --shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
            --transition: all 0.2s ease;
            
            /* Theme Variables - Light (Default) */
            --bg-body: var(--gray-50);
            --bg-card: #ffffff;
            --border-color: var(--gray-200);
            --border-color-light: var(--gray-100);
            --text-main: var(--gray-800);
            --text-muted: var(--gray-500);
            --text-heading: var(--gray-900);
            --bg-hover: var(--gray-50);
        }

        /* Theme Variables - Dark */
        [data-theme="dark"] {
            --gray-50: #111827;
            --gray-100: #1F2937;
            --gray-200: #374151;
            --gray-300: #4B5563;
            --gray-400: #6B7280;
            --gray-500: #9CA3AF;
            --gray-600: #D1D5DB;
            --gray-700: #E5E7EB;
            --gray-800: #F3F4F6;
            --gray-900: #F9FAFB;
            
            --bg-body: #0B1120;
            --bg-card: #111827;
            --border-color: #1F2937;
            --border-color-light: #1F2937;
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --text-heading: #ffffff;
            --bg-hover: #1F2937;
            
            --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.3);
            --shadow: 0 1px 3px 0 rgba(0,0,0,0.5), 0 1px 2px -1px rgba(0,0,0,0.5);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.5), 0 2px 4px -2px rgba(0,0,0,0.5);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--gray-900) 0%, var(--gray-800) 100%);
            color: #fff;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: -0.5px;
        }

        .sidebar-brand-text h1 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .sidebar-brand-text p {
            font-size: 11px;
            color: var(--gray-400);
            font-weight: 400;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .sidebar-nav-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--gray-500);
            padding: 8px 16px 8px;
            margin-top: 8px;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-300);
            transition: var(--transition);
            margin-bottom: 2px;
        }

        .sidebar-nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .sidebar-nav-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .sidebar-nav-item i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,0.05);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-info h4 {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-info p {
            font-size: 11px;
            color: var(--gray-400);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: var(--topbar-height);
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-left h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-heading);
        }

        .topbar-breadcrumb {
            font-size: 13px;
            color: var(--gray-400);
        }

        .topbar-breadcrumb a {
            color: var(--gray-500);
            transition: var(--transition);
        }

        .topbar-breadcrumb a:hover { color: var(--primary); }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--bg-hover);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
        }

        .btn-logout:hover {
            background: var(--danger-light);
            color: var(--danger);
            border-color: var(--danger);
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 28px 32px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-heading);
        }

        .page-header p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-heading);
        }

        .card-body { padding: 24px; }
        .card-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color-light);
            background: var(--bg-body);
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-card-icon.blue { background: var(--info-light); color: var(--info); }
        .stat-card-icon.green { background: var(--success-light); color: var(--success); }
        .stat-card-icon.yellow { background: var(--warning-light); color: var(--warning); }
        .stat-card-icon.red { background: var(--danger-light); color: var(--danger); }
        .stat-card-icon.indigo { background: var(--primary-50); color: var(--primary); }

        .stat-card-info h4 {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .stat-card-info .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-heading);
            line-height: 1;
        }

        .stat-card-info .stat-sub {
            font-size: 12px;
            color: var(--gray-400);
            margin-top: 4px;
        }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            background: var(--bg-body);
            border-bottom: 1px solid var(--border-color);
        }

        table td {
            padding: 14px 16px;
            font-size: 14px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color-light);
            vertical-align: middle;
        }

        table tbody tr {
            transition: var(--transition);
        }

        table tbody tr:hover {
            background: var(--bg-hover);
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== BADGES ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-pending { background: var(--warning-light); color: #92400E; }
        .badge-process, .badge-approved { background: var(--info-light); color: #1E40AF; }
        .badge-resolved, .badge-paid { background: var(--success-light); color: #065F46; }
        .badge-rejected, .badge-unpaid { background: var(--danger-light); color: #991B1B; }
        .badge-verified { background: var(--success-light); color: #065F46; }
        .badge-unverified { background: var(--warning-light); color: #92400E; }

        .badge i { font-size: 8px; }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            border: 1px solid transparent;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }

        .btn-xs {
            padding: 4px 10px;
            font-size: 12px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.45);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success);
            color: #fff;
        }

        .btn-success:hover { background: #059669; }

        .btn-warning {
            background: var(--warning);
            color: #fff;
        }

        .btn-warning:hover { background: #D97706; }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover { background: #DC2626; }

        .btn-info {
            background: var(--info);
            color: #fff;
        }

        .btn-info:hover { background: #2563EB; }

        .btn-outline {
            background: transparent;
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .btn-outline:hover {
            background: var(--bg-hover);
            border-color: var(--text-muted);
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
        }

        /* ===== FORMS ===== */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-family: inherit;
            color: var(--text-main);
            background: var(--bg-card);
            transition: var(--transition);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .form-input.is-invalid,
        .form-select.is-invalid,
        .form-textarea.is-invalid {
            border-color: var(--danger);
        }

        .form-textarea { resize: vertical; min-height: 100px; }

        .form-error {
            font-size: 13px;
            color: var(--danger);
            margin-top: 4px;
        }

        .form-hint {
            font-size: 12px;
            color: var(--gray-400);
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }

        .alert-success { background: var(--success-light); color: #065F46; border: 1px solid #A7F3D0; }
        .alert-error { background: var(--danger-light); color: #991B1B; border: 1px solid #FECACA; }
        .alert-warning { background: var(--warning-light); color: #92400E; border: 1px solid #FDE68A; }
        .alert-info { background: var(--info-light); color: #1E40AF; border: 1px solid #93C5FD; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== FILTERS BAR ===== */
        .filters-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filters-bar .form-input,
        .filters-bar .form-select {
            width: auto;
            min-width: 200px;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
        }

        .pagination-info {
            font-size: 13px;
            color: var(--gray-500);
        }

        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
        }

        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .pagination li a:hover {
            background: var(--primary-50);
            color: var(--primary);
            border-color: var(--primary);
        }

        .pagination li.active span {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .pagination li.disabled span {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: var(--bg-card);
            border-radius: var(--radius);
            width: 90%;
            max-width: 480px;
            box-shadow: var(--shadow-lg);
            animation: modalIn 0.2s ease;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 18px;
            color: var(--gray-400);
            cursor: pointer;
            padding: 4px;
        }

        .modal-body { padding: 24px; }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color-light);
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        /* ===== MOBILE TOGGLE ===== */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--gray-600);
            cursor: pointer;
            padding: 4px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 999;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay.active { display: block; }

            .sidebar-toggle { display: block; }

            .main-content { margin-left: 0; }

            .topbar { padding: 0 16px; }
            .page-content { padding: 20px 16px; }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .filters-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filters-bar .form-input,
            .filters-bar .form-select {
                width: 100%;
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('logo.png') }}" alt="SIRA Logo" style="width: 42px; height: 42px; object-fit: contain;">
            <div class="sidebar-brand-text">
                <h1>SIRA</h1>
                <p>Sistem Informasi RT/RW</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->isAdmin())
                <div class="sidebar-nav-label">Menu Utama</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>

                <div class="sidebar-nav-label">Manajemen</div>
                <a href="{{ route('admin.warga.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Data Warga
                </a>
                <a href="{{ route('admin.surat.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text"></i> Surat Pengantar
                </a>
                <a href="{{ route('admin.pengaduan.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Pengaduan
                </a>
                <a href="{{ route('admin.iuran.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.iuran.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i> Iuran Bulanan
                </a>
            @else
                <div class="sidebar-nav-label">Menu Utama</div>
                <a href="{{ route('warga.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <div class="sidebar-nav-label">Layanan</div>
                <a href="{{ route('warga.surat.index') }}" class="sidebar-nav-item {{ request()->routeIs('warga.surat.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text"></i> Surat Pengantar
                </a>
                <a href="{{ route('warga.pengaduan.index') }}" class="sidebar-nav-item {{ request()->routeIs('warga.pengaduan.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Pengaduan
                </a>
                <a href="{{ route('warga.iuran.index') }}" class="sidebar-nav-item {{ request()->routeIs('warga.iuran.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i> Iuran Bulanan
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>{{ auth()->user()->isAdmin() ? 'Pengurus RT' : 'Warga' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h2>@yield('page-title', 'Dashboard')</h2>
                </div>
            </div>
            <div class="topbar-right">
                <button id="themeToggleBtn" class="btn-icon" style="background: transparent; color: var(--text-muted); border: none; font-size: 18px; cursor: pointer; margin-right: 8px;">
                    <i class="fas fa-moon"></i>
                </button>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
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
    </main>

    <script>
        // Theme Toggle Logic
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = themeToggleBtn.querySelector('i');
        
        function updateThemeIcon() {
            if (document.documentElement.getAttribute('data-theme') === 'dark') {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }
        
        // Initial icon update
        updateThemeIcon();

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon();
            
            // Dispatch event for components that need to react (like charts)
            window.dispatchEvent(new Event('themeChanged'));
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        // Auto-dismiss alerts
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-8px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>
</html>
