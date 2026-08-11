<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRA - Sistem Informasi & Pelaporan RT/RW</title>
    <meta name="description" content="SIRA adalah platform digital untuk layanan RT/RW — pengajuan surat, pelaporan pengaduan, dan pencatatan iuran bulanan secara online.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1F2937;
            line-height: 1.6;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            padding: 16px 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 10px 0;
        }

        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 22px;
            color: #fff;
        }

        .navbar.scrolled .nav-brand { color: #1F2937; }

        .nav-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4F46E5, #0EA5E9);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.8);
            transition: all 0.2s ease;
        }

        .navbar.scrolled .nav-links a { color: #4B5563; }

        .nav-links a:hover { color: #fff; }
        .navbar.scrolled .nav-links a:hover { color: #4F46E5; }

        .btn-nav {
            padding: 10px 24px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .navbar.scrolled .btn-nav {
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            border-color: transparent;
            color: #fff;
        }

        .btn-nav:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-1px);
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 40%, #312E81 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
            top: -10%;
            right: -5%;
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14,165,233,0.15) 0%, transparent 70%);
            bottom: -15%;
            left: -5%;
            border-radius: 50%;
        }

        .hero .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 52px;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }

        .hero-content h1 span {
            background: linear-gradient(135deg, #818CF8, #38BDF8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 18px;
            color: rgba(255,255,255,0.6);
            line-height: 1.8;
            margin-bottom: 36px;
            max-width: 500px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            color: #fff;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 8px 24px rgba(79,70,229,0.4);
            transition: all 0.3s ease;
        }

        .btn-hero-primary:hover {
            box-shadow: 0 12px 32px rgba(79,70,229,0.55);
            transform: translateY(-2px);
        }

        .btn-hero-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: transparent;
            color: rgba(255,255,255,0.8);
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-hero-outline:hover {
            border-color: rgba(255,255,255,0.5);
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        /* Hero Visual */
        .hero-visual {
            position: relative;
        }

        .hero-card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 32px;
            color: #fff;
        }

        .hero-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .hero-card-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .hero-card-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .hero-stat {
            background: rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .hero-stat i {
            font-size: 24px;
            margin-bottom: 8px;
            opacity: 0.7;
        }

        .hero-stat .value {
            font-size: 28px;
            font-weight: 800;
            display: block;
        }

        .hero-stat .label {
            font-size: 12px;
            opacity: 0.5;
            margin-top: 2px;
        }

        .hero-floating-card {
            position: absolute;
            background: rgba(255,255,255,0.95);
            border-radius: 14px;
            padding: 16px 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: float 3s ease-in-out infinite;
            color: #1F2937;
        }

        .hero-floating-card.top-right {
            top: -20px;
            right: -20px;
            animation-delay: 0.5s;
        }

        .hero-floating-card.bottom-left {
            bottom: -16px;
            left: -20px;
            animation-delay: 1s;
        }

        .floating-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .floating-icon.green { background: #D1FAE5; color: #059669; }
        .floating-icon.blue { background: #DBEAFE; color: #2563EB; }

        .floating-text h5 { font-size: 13px; font-weight: 700; }
        .floating-text p { font-size: 11px; color: #6B7280; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ===== FEATURES ===== */
        .features {
            padding: 100px 0;
            background: #F9FAFB;
        }

        .features .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: #EEF2FF;
            color: #4F46E5;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .section-header h2 {
            font-size: 36px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }

        .section-header p {
            font-size: 16px;
            color: #6B7280;
            max-width: 560px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #E5E7EB;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .feature-icon.indigo { background: #EEF2FF; color: #4F46E5; }
        .feature-icon.blue { background: #DBEAFE; color: #2563EB; }
        .feature-icon.green { background: #D1FAE5; color: #059669; }
        .feature-icon.amber { background: #FEF3C7; color: #D97706; }
        .feature-icon.rose { background: #FFE4E6; color: #E11D48; }
        .feature-icon.cyan { background: #CFFAFE; color: #0891B2; }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .feature-card p {
            font-size: 14px;
            color: #6B7280;
            line-height: 1.7;
        }

        /* ===== CTA ===== */
        .cta {
            padding: 80px 0;
            background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);
            text-align: center;
            color: #fff;
        }

        .cta .container {
            max-width: 640px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .cta h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .cta p {
            font-size: 16px;
            opacity: 0.7;
            margin-bottom: 32px;
        }

        /* ===== FOOTER ===== */
        .footer {
            padding: 32px 0;
            background: #0F172A;
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 14px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero .container {
                grid-template-columns: 1fr;
                gap: 40px;
                padding-top: 100px;
                padding-bottom: 60px;
            }

            .hero-content h1 { font-size: 32px; }
            .hero-visual { display: none; }
            .hero-actions { flex-direction: column; }
            .features-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-brand">
                <div class="nav-brand-icon">S</div>
                SIRA
            </a>
            <div class="nav-links">
                <a href="#features">Fitur</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="btn-nav">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Layanan RT/RW <span>Digital & Transparan</span></h1>
                <p>SIRA memudahkan warga dalam mengajukan surat pengantar, melaporkan pengaduan, dan memantau iuran bulanan secara online.</p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-hero-primary">
                        <i class="fas fa-rocket"></i> Mulai Sekarang
                    </a>
                    <a href="#features" class="btn-hero-outline">
                        <i class="fas fa-arrow-down"></i> Pelajari Fitur
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card">
                    <div class="hero-card-header">
                        <span class="hero-card-dot" style="background: #EF4444;"></span>
                        <span class="hero-card-dot" style="background: #F59E0B;"></span>
                        <span class="hero-card-dot" style="background: #10B981;"></span>
                        <span style="font-size: 13px; opacity: 0.5; margin-left: auto;">Dashboard SIRA</span>
                    </div>
                    <div class="hero-card-stats">
                        <div class="hero-stat">
                            <i class="fas fa-users"></i>
                            <span class="value">256</span>
                            <span class="label">Total Warga</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fas fa-envelope"></i>
                            <span class="value">42</span>
                            <span class="label">Surat Bulan Ini</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fas fa-bullhorn"></i>
                            <span class="value">8</span>
                            <span class="label">Pengaduan Aktif</span>
                        </div>
                        <div class="hero-stat">
                            <i class="fas fa-money-bill-wave"></i>
                            <span class="value">94%</span>
                            <span class="label">Iuran Terbayar</span>
                        </div>
                    </div>
                </div>

                <div class="hero-floating-card top-right">
                    <div class="floating-icon green"><i class="fas fa-check"></i></div>
                    <div class="floating-text">
                        <h5>Surat Disetujui</h5>
                        <p>Pengantar KTP — Budi S.</p>
                    </div>
                </div>

                <div class="hero-floating-card bottom-left">
                    <div class="floating-icon blue"><i class="fas fa-bell"></i></div>
                    <div class="floating-text">
                        <h5>Pengaduan Baru</h5>
                        <p>Lampu Jalan Padam</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">
                    <i class="fas fa-sparkles"></i> Fitur Unggulan
                </div>
                <h2>Semua Layanan RT/RW dalam Satu Platform</h2>
                <p>Digitalisasi layanan warga untuk proses yang lebih cepat, transparan, dan terorganisir.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon indigo"><i class="fas fa-envelope-open-text"></i></div>
                    <h3>Surat Pengantar Online</h3>
                    <p>Ajukan surat pengantar KTP, SKCK, domisili, dan lainnya secara online tanpa perlu datang ke rumah RT.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon amber"><i class="fas fa-bullhorn"></i></div>
                    <h3>Laporan Pengaduan</h3>
                    <p>Laporkan masalah lingkungan seperti lampu padam, sampah menumpuk, atau fasilitas rusak lengkap dengan foto bukti.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon green"><i class="fas fa-money-bill-wave"></i></div>
                    <h3>Iuran Bulanan</h3>
                    <p>Pantau tagihan dan riwayat pembayaran iuran bulanan RT secara transparan dan real-time.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon blue"><i class="fas fa-file-pdf"></i></div>
                    <h3>Cetak Surat PDF</h3>
                    <p>Surat pengantar yang disetujui dapat langsung dicetak atau diunduh dalam format PDF.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon rose"><i class="fas fa-user-shield"></i></div>
                    <h3>Verifikasi Akun</h3>
                    <p>Setiap pendaftaran warga baru diverifikasi oleh Pengurus RT untuk keamanan data.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon cyan"><i class="fas fa-chart-bar"></i></div>
                    <h3>Dashboard Statistik</h3>
                    <p>Pengurus RT dapat memantau seluruh aktivitas warga melalui dashboard dengan statistik lengkap.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <h2>Siap Bergabung dengan SIRA?</h2>
            <p>Daftarkan diri Anda sekarang dan nikmati kemudahan layanan RT/RW digital.</p>
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} SIRA - Sistem Informasi & Pelaporan RT/RW. All rights reserved.</p>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
