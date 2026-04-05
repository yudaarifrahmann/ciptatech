<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciptatech - Kerja Jadi Lebih Gampang</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --dark: #0f172a;
            --light-bg: #ffffff;
            --soft-gray: #f8fafc;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark);
            overflow-x: hidden;
        }

        .navbar {
            padding: 1.5rem 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 1rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.9);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark) !important;
        }

        .hero-section {
            padding: 100px 0;
            background: radial-gradient(circle at top right, rgba(67, 97, 238, 0.05), transparent 400px);
        }

        .hero-title {
            font-weight: 700;
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 2.5rem;
            max-width: 550px;
        }

        .btn-gaskeun {
            padding: 12px 32px;
            font-weight: 600;
            border-radius: 14px;
            background: var(--primary);
            border: none;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        }

        .btn-gaskeun:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .stat-card {
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .stat-val {
            font-weight: 700;
            font-size: 2rem;
            color: var(--primary);
            display: block;
        }

        .stat-desc {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .about-section {
            padding: 100px 0;
            background-color: var(--soft-gray);
            border-radius: 60px;
            margin: 60px 0;
        }

        .workflow-step {
            position: relative;
            padding: 2.5rem;
            background: white;
            border-radius: 30px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #f1f5f9;
        }

        .workflow-step:hover {
            transform: scale(1.05);
            box-shadow: 0 30px 60px rgba(67, 97, 238, 0.1);
            z-index: 2;
        }

        .step-num {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }

        .floating-icon {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .pulse-btn {
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% { box-shadow: 0 0 0 0px rgba(67, 97, 238, 0.4); }
            70% { box-shadow: 0 0 0 20px rgba(67, 97, 238, 0); }
            100% { box-shadow: 0 0 0 0px rgba(67, 97, 238, 0); }
        }

        .learning-section {
            padding: 100px 0;
        }

        .check-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .check-item i {
            color: #10b981;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .role-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            height: 100%;
        }

        .role-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.05);
        }

        .testimonial-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid #f1f5f9;
            height: 100%;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--soft-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary);
            margin-right: 1rem;
        }

        .faq-item {
            background: white;
            border-radius: 20px;
            margin-bottom: 1.25rem;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: var(--primary);
        }

        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
        }

        .division-card {
            padding: 2.5rem;
            border-radius: 30px;
            background: white;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            height: 100%;
        }

        .division-card:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-5px);
        }

        .division-card:hover .icon-pemanis {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .feature-grid-item {
            padding: 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-grid-item:hover {
            background: #f8faff;
        }

        .feature-grid-item i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.25rem;
            display: block;
        }

        .cta-final-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            color: white;
            border-radius: 60px;
            margin: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-final-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            top: -200px;
            right: -200px;
        }

        footer {
            padding: 4rem 0;
            border-top: 1px solid #f1f5f9;
            color: #94a3b8;
            font-size: 1rem;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.25rem;
            }
            .hero-section {
                padding: 60px 0;
                text-align: center;
            }
            .hero-subtitle {
                margin: 0 auto 2rem;
            }
            .about-section {
                padding: 60px 0;
                margin: 40px 0;
                border-radius: 40px;
            }
            .stat-val {
                font-size: 1.5rem;
            }
            .stat-desc {
                font-size: 0.8rem;
            }
            .stat-card {
                padding: 1rem;
            }
            .navbar-brand {
                font-size: 1.25rem;
            }
            .cta-final-section {
                padding: 60px 0;
                margin: 60px 0;
                border-radius: 40px;
            }
            .learning-section {
                padding: 60px 0;
                text-align: center;
            }
            section[style*="border-radius: 60px"] {
                border-radius: 40px !important;
                margin: 40px 0 !important;
            }
            .btn-gaskeun {
                padding: 10px 24px;
            }
            .learning-section .check-item {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-bolt me-2 text-primary"></i>CIPTATECH
            </a>
            <div class="ms-auto d-flex align-items-center gap-2">
                @guest
                    <a href="{{ route('register.superadmin') }}" class="btn btn-primary rounded-pill px-3 px-md-4 fw-bold">Daftar</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-3 px-md-4 fw-bold">Masuk</a>
                @else
                    @php
                        $dashboardRoute = match(auth()->user()->role) {
                            'superadmin' => route('superadmin.dashboard'),
                            'supervisor' => route('supervisor.dashboard'),
                            'PIC'        => route('pic.dashboard'),
                            default      => route('landing'),
                        };
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="btn btn-primary rounded-pill px-3 px-md-4 fw-bold">Buka Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger rounded-pill px-3 px-md-4 fw-bold">Keluar</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Bikin Laporan Gak Pake Ribet.</h1>
                    <p class="hero-subtitle">Platform simpel buat kalian yang mau pantau tugas dan kirim laporan harian jadi lebih cepet dan sat-set!</p>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-gaskeun">Gaskeun Login <i class="fas fa-chevron-right ms-2 small"></i></a>
                    @else
                        <a href="{{ $dashboardRoute }}" class="btn btn-gaskeun">Lanjut Kerja <i class="fas fa-arrow-right ms-2 small"></i></a>
                    @endguest
                    
                    <div class="row mt-5 g-3">
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <span class="stat-val">{{ $stats['tasks_completed'] ?? 0 }}</span>
                                <span class="stat-desc">Beres</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <span class="stat-val">{{ $stats['users'] ?? 0 }}</span>
                                <span class="stat-desc">User</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <span class="stat-val">{{ $stats['divisions'] ?? 0 }}</span>
                                <span class="stat-desc">Divisi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="ps-5">
                        <img src="https://img.freepik.com/free-vector/creative-team-concept-illustration_114360-3733.jpg?w=826" alt="Hero" class="img-fluid rounded-5 shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section animate-on-scroll">
        <div class="container">
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-7">
                    <h2 class="fw-bold mb-3">Gimana Sih Cara Mainnya?</h2>
                    <p class="text-muted">Gak pake ribet, cuma butuh 3 langkah buat kalian yang mau lapor tugas atau pantau kerjaan tim.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="workflow-step">
                        <div class="step-num">1</div>
                        <div class="floating-icon mb-4" style="animation-delay: 0s;">
                            <i class="fas fa-tasks fa-3x text-primary opacity-25"></i>
                        </div>
                        <h5 class="fw-bold">Pilih Tugasnya</h5>
                        <p class="text-muted small">Cek daftar tugas yang udah disiapin buat kalian. Tinggal pilih yang mau digarap duluan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="workflow-step">
                        <div class="step-num">2</div>
                        <div class="floating-icon mb-4" style="animation-delay: 0.5s;">
                            <i class="fas fa-pencil-ruler fa-3x text-primary opacity-25"></i>
                        </div>
                        <h5 class="fw-bold">Kerjain & Fokus</h5>
                        <p class="text-muted small">Fokus kerjain tugas kalian. Kalo bingung, ada fitur feedback buat tanya-tanya supervisor.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="workflow-step">
                        <div class="step-num">3</div>
                        <div class="floating-icon mb-4" style="animation-delay: 1s;">
                            <i class="fas fa-paper-plane fa-3x text-primary opacity-25"></i>
                        </div>
                        <h5 class="fw-bold">Sat-set Lapor!</h5>
                        <p class="text-muted small">Tulis progress, upload bukti (gambar/video), trus kirim. Status bakal otomatis update!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Section -->
    <section class="learning-section animate-on-scroll">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="{{ asset('images/11667116_20944999.jpg') }}" alt="Team Collaboration" class="img-fluid rounded-5 shadow-lg">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-bold mb-4">Gak Cuma Kerja, Tapi Sambil Belajar 💡</h2>
                    <p class="text-muted mb-4 lead">Ciptatech emang sengaja dibikin dengan sistem feedback yang mantap. Jadi kalian gak cuma asal selesaiin tugas, tapi dapet ilmu juga.</p>
                    
                    <div class="check-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Supervisor kasih feedback langsung ke tugasmu</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Revisi bukan beban, tapi kesempatan belajar</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Diskusi dua arah lewat fitur komentar</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Tracking skill progress lewat history laporan</span>
                    </div>
                    
                    <div class="mt-5">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-gaskeun pulse-btn">Ayo Mulai Belajar!</a>
                        @else
                            <a href="{{ $dashboardRoute }}" class="btn btn-gaskeun pulse-btn">Lanjut Belajar!</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-5 bg-light animate-on-scroll" style="border-radius: 60px; margin: 40px 0;">
        <div class="container py-5">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="fw-bold fs-1">Kenapa Harus Ciptatech?</h2>
                    <p class="text-muted">Banyak alasan kenapa tim kita milih platform ini buat nemenin kerja harian.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="division-card">
                        <div class="icon-pemanis"><i class="fas fa-rocket"></i></div>
                        <h5 class="fw-bold">Super Sat-set</h5>
                        <p class="text-muted small">Lapor tugas cuma butuh hitungan detik. Gak ada lagi drama form ribet atau loading lama!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="division-card">
                        <div class="icon-pemanis"><i class="fas fa-microscope"></i></div>
                        <h5 class="fw-bold">Detail Pol!</h5>
                        <p class="text-muted small">Semua data kerekam rapi. Dari progress 0% sampe 100%, semua history-nya aman terkendali.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="division-card">
                        <div class="icon-pemanis"><i class="fas fa-heart"></i></div>
                        <h5 class="fw-bold">Gampang Banget</h5>
                        <p class="text-muted small">Tampilannya bersih, gak bikin pusing. Siapapun pasti langsung jago pakenya dalam sekejap.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 animate-on-scroll">
        <div class="container py-5">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="fw-bold fs-1">Kata Mereka Yang Udah Pake</h2>
                    <p class="text-muted">Dengerin langsung cerita dari temen-temen kita.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p class="mb-4">"Dulu lapor tugas via WA berantakan banget. Sejak pake Ciptatech, semua jadi rapi dan terpantau!"</p>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar">YA</div>
                            <div>
                                <h6 class="fw-bold mb-0">Yuda Arif</h6>
                                <small class="text-muted">PIC Software Host</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p class="mb-4">"Review dari supervisor bener-bener ngebantu aku belajar hal baru tiap hari. Gaskeun!"</p>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar">SN</div>
                            <div>
                                <h6 class="fw-bold mb-0">Siti Nurul</h6>
                                <small class="text-muted">PIC Multimedia</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p class="mb-4">"Dashboard-nya enak banget dilihat, simpel tapi fiturnya lengkap banget buat monitor tim."</p>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar">AD</div>
                            <div>
                                <h6 class="fw-bold mb-0">Adi Prasetyo</h6>
                                <small class="text-muted">Supervisor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Ecosystem -->
    <section class="py-5 bg-light animate-on-scroll" style="border-radius: 60px; margin: 40px 0;">
        <div class="container py-5">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="fw-bold fs-1">Siapa Aja Yang Ada Di Sini?</h2>
                    <p class="text-muted">Ciptatech ngebantu semua orang di tim buat kolaborasi lebih enak.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="role-card">
                        <div class="icon-pemanis"><i class="fas fa-user-shield"></i></div>
                        <h5 class="fw-bold">Super Admin</h5>
                        <p class="text-muted small">Si Bos Besar yang ngatur segalanya. Dari nambahin user, bikin divisi, sampe liat audit trail biat sistem aman jaya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-card">
                        <div class="icon-pemanis"><i class="fas fa-user-tie"></i></div>
                        <h5 class="fw-bold">Supervisor</h5>
                        <p class="text-muted small">Sang Mentor yang mantau progress kalian. Dia yang bakal kasih feedback dan approval biar tugas kalian makin mantap.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-card">
                        <div class="icon-pemanis"><i class="fas fa-user-ninja"></i></div>
                        <h5 class="fw-bold">PIC (Garda Terdepan)</h5>
                        <p class="text-muted small">Kalian yang eksekusi di lapangan! Lapor progress tiap hari dan serap ilmu sebanyak-banyaknya dari supervisor.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advanced Features Grid -->
    <section class="py-5 bg-white animate-on-scroll">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <h2 class="fw-bold mb-4">Fitur Canggih Yang Bikin Betah</h2>
                    <p class="text-muted mb-4">Gak cuma lapor, kita juga kasih banyak fitur tambahan yang ngebantu productivity kalian naik level.</p>
                    <a href="{{ route('login') }}" class="btn btn-gaskeun mb-4">Eksplor Sekarang</a>
                </div>
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-grid-item">
                                <i class="fas fa-history"></i>
                                <h6 class="fw-bold">Audit Trail Pinter</h6>
                                <p class="text-muted small">Semua aktivitas sitem kerekam rapi, jadi gak ada yang bisa "ngilang" diam-diam.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-grid-item">
                                <i class="fas fa-file-export"></i>
                                <h6 class="fw-bold">Log Laporan Otomatis</h6>
                                <p class="text-muted small">Gak perlu repot rekap manual, sistem bakal siapin log laporan yang rapi buat kalian.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-grid-item">
                                <i class="fas fa-mobile-screen-button"></i>
                                <h6 class="fw-bold">Mobile Friendly</h6>
                                <p class="text-muted small">Bisa diakses lewat HP sambil rebahan atau lagi di jalan. Responsif abis!</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-grid-item">
                                <i class="fas fa-lock"></i>
                                <h6 class="fw-bold">Keamanan Terjamin</h6>
                                <p class="text-muted small">Data kalian aman pake sistem enkripsi terbaru. Privasi tetep nomor satu!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light animate-on-scroll" style="border-radius: 60px; margin: 40px 0;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold text-center mb-5 fs-1">Tanya-Tanya Dulu</h2>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Lapor tugas harus tiap hari?</span>
                            <i class="fas fa-plus small text-muted"></i>
                        </div>
                        <div class="px-4 pb-3 text-muted small" style="display: none;">
                            Iya dong, makin sering lapor makin kelihatan progresmu. Supervisor juga seneng liat timnya aktif.
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Bisa upload video yang gede?</span>
                            <i class="fas fa-plus small text-muted"></i>
                        </div>
                        <div class="px-4 pb-3 text-muted small" style="display: none;">
                            Bisa banget! Bagian Multimedia emang disiapin buat handle file video yang cinematic.
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Kalo dapet revisi gimana?</span>
                            <i class="fas fa-plus small text-muted"></i>
                        </div>
                        <div class="px-4 pb-3 text-muted small" style="display: none;">
                            Santai aja, revisi itu biar kerjaanmu makin sempurna. Tinggal edit laporan lamamu trus kirim lagi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="container animate-on-scroll">
        <div class="cta-final-section text-center">
            <h2 class="fw-bold mb-4 fs-1">Udah Siap Join Tim Ciptatech?</h2>
            <p class="mb-5 opacity-75">Gak usah tunggu lama-lama, langsung masuk dan mulai kolaborasi bareng kita!</p>
            @guest
                <a href="{{ route('login') }}" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-primary pulse-btn">Ayo Masuk Sekarang!</a>
            @else
                <a href="{{ $dashboardRoute }}" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-primary pulse-btn">Balik ke Dashboard</a>
            @endguest
        </div>
    </section>

    <footer class="text-center">
        <div class="container">
            <div class="mb-4">
                <a href="#" class="navbar-brand">
                    <i class="fas fa-bolt me-2 text-primary"></i>CIPTATECH
                </a>
            </div>
            <p class="mb-1">Dibuat dengan semangat oleh Tim Ciptatech &copy; 2026</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar Scrolled Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Simple Scroll Animation
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, observerOptions);
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

        // FAQ Toggle
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const answer = q.nextElementSibling;
                const icon = q.querySelector('i');
                const isVisible = answer.style.display === 'block';
                
                answer.style.display = isVisible ? 'none' : 'block';
                icon.classList.toggle('fa-plus', isVisible);
                icon.classList.toggle('fa-minus', !isVisible);
            });
        });
    </script>
</body>
</html>
