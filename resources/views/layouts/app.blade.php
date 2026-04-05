<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #06d6a0;
            --warning-color: #ffd166;
            --danger-color: #ef476f;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            padding-top: 56px;
        }

        .navbar {
            background: linear-gradient(135deg, #2a2d3e 0%, #212529 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            height: 56px;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .navbar-brand i {
            color: var(--accent-color);
        }

        .user-profile-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-logout-mobile {
            background: transparent;
            border: 1px solid rgba(239, 71, 111, 0.3);
            color: #ff6b8b;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-logout-mobile:hover {
            background: rgba(239, 71, 111, 0.2);
            border-color: rgba(239, 71, 111, 0.4);
            color: white;
            transform: translateY(-2px);
        }

        .desktop-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info-desktop {
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info-desktop i {
            color: var(--accent-color);
        }

        .btn-logout-desktop {
            background: rgba(239, 71, 111, 0.2);
            border: 1px solid rgba(239, 71, 111, 0.3);
            color: #ff6b8b;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-logout-desktop:hover {
            background: rgba(239, 71, 111, 0.3);
            border-color: rgba(239, 71, 111, 0.4);
            color: white;
            transform: translateY(-2px);
        }

        .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9ff 100%);
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.03);
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            left: 0;
            width: var(--sidebar-width);
            padding: 25px 15px;
            border-right: 1px solid #eaeaea;
            overflow-y: auto;
            z-index: 1020;
        }
        
        .sidebar h6 {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #6c757d;
            margin-top: 20px;
            margin-bottom: 15px;
            padding-left: 10px;
        }
        
        .nav-link {
            color: #495057;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link i {
            width: 22px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }
        
        .nav-link:hover {
            background-color: rgba(67, 97, 238, 0.08);
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }

        .content-area {
            padding: 25px;
            min-height: calc(100vh - 56px);
            margin-left: var(--sidebar-width);
        }
        
        .content-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .content-header h1 {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .content-header .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .dashboard-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: rgba(6, 214, 160, 0.15);
            color: #06a179;
        }
        
        .badge-warning {
            background-color: rgba(255, 209, 102, 0.15);
            color: #cc9e00;
        }
        
        .badge-danger {
            background-color: rgba(239, 71, 111, 0.15);
            color: #d12652;
        }
        
        .app-footer {
            padding: 15px 0;
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            border-top: 1px solid #eaeaea;
            margin-top: 30px;
        }

        /* ===== RESPONSIVE MOBILE STYLES ===== */
        
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 8px 0;
        }

        .bottom-nav-item {
            flex: 1;
            text-align: center;
            padding: 8px 5px;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .bottom-nav-item i {
            font-size: 1.3rem;
            margin-bottom: 4px;
        }

        .bottom-nav-item span {
            font-size: 0.7rem;
            font-weight: 500;
        }

        .bottom-nav-item.active {
            color: var(--primary-color);
        }

        .bottom-nav-item:hover {
            color: var(--primary-color);
        }

        @media (max-width: 992px) {
            .sidebar {
                display: none !important;
            }

            .bottom-nav {
                display: flex;
            }

            .content-area {
                margin-left: 0;
                padding: 15px;
                padding-bottom: 80px;
                min-height: calc(100vh - 56px);
            }

            .desktop-user-info {
                display: none !important;
            }

            .navbar .container-fluid {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 10px;
            }

            .navbar-toggler {
                display: none;
            }

            .navbar-brand {
                order: 1;
                justify-content: flex-start;
                font-size: 1.1rem;
                flex: 1;
            }

            .navbar-brand i {
                display: none;
            }

            .mobile-user-actions {
                order: 2;
                display: flex;
                align-items: center;
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1rem;
            }

            .content-area {
                padding: 10px;
                padding-bottom: 80px;
            }

            .content-header h1 {
                font-size: 1.4rem;
            }

            .content-header .breadcrumb {
                font-size: 0.8rem;
            }

            .dashboard-card {
                margin-bottom: 15px;
            }

            .app-footer {
                padding-bottom: 70px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .bottom-nav-item span {
                font-size: 0.65rem;
            }

            .bottom-nav-item i {
                font-size: 1.2rem;
            }

            .navbar-brand {
                font-size: 0.9rem;
            }

            .user-profile-circle {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .btn-logout-mobile {
                width: 32px;
                height: 32px;
            }
            
            .content-area {
                padding: 8px;
                padding-bottom: 80px;
            }
        }

        /* Desktop styles */
        @media (min-width: 993px) {
            .mobile-user-actions {
                display: none !important;
            }
            
            .bottom-nav {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-chart-network d-none d-md-inline"></i>
            <span>CIPTATECH</span>
        </a>
    
            <div class="desktop-user-info">
            <div class="user-info-desktop d-flex align-items-center">
                <i class="fas fa-user-circle me-2"></i>
                <span>{{ auth()->user()->name }} <small class="text-white">({{ auth()->user()->role }})</small></span>
            </div>
                <!-- Notification dropdown -->
                <div class="ms-3 me-2">
                    <div class="dropdown d-inline">
                        <button class="btn btn-link text-white position-relative p-0 me-3" id="notifDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="badge bg-danger text-white position-absolute" id="notifBadge" style="top:-6px; right:-6px;">{{ auth()->user()->unreadNotifications()->count() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdownBtn" style="width:360px;">
                            <li id="notifDropdownList"><div class="text-center text-muted py-2">Memuat...</div></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="text-center"><a id="notifViewAllLink" href="/{{ strtolower(auth()->user()->role) }}/notifications" class="small">Lihat semua notifikasi</a></li>
                        </ul>
                    </div>
                </div>

            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="btn btn-logout-desktop d-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
        
        <!-- Mobile User -->
        <div class="mobile-user-actions">
            
            <div class="user-profile-circle">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="btn btn-logout-mobile">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Sidebar (Desktop Only) -->
<aside class="sidebar d-print-none d-none d-lg-block">
    <!-- PIC -->
    @if (in_array(auth()->user()->role, ['PIC']))
        <h6><i class="fas fa-user-tie me-2"></i> MENU PIC</h6>
        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link" href="/pic">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pic/report/create">
                    <i class="fas fa-plus-circle"></i>
                    <span>Lapor Tugas Mingguan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pic/daily-report">
                    <i class="fas fa-calendar-day"></i>
                    <span>Daily report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pic/tasks">
                    <i class="fas fa-list-check"></i>
                    <span>Daftar Tugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pic/report/history">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Laporan</span>
                </a>
             </li>
            <li class="nav-item">
                <a class="nav-link" href="/pic/profile">
                    <i class="fas fa-user-cog"></i>
                    <span>Profil & Pengaturan</span>
                </a>
            </li>
            
        </ul>
    @endif

    <!-- SUPERVISOR -->
    @if (in_array(auth()->user()->role, ['supervisor']))
        <h6><i class="fas fa-user-shield me-2"></i> MENU SUPERVISOR</h6>
        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link" href="/supervisor">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard Utama</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/supervisor/tasks">
                    <i class="fas fa-tasks"></i>
                    <span>Kelola Tugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/supervisor/monitoring">
                    <i class="fas fa-project-diagram"></i>
                    <span>Monitoring Tugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/supervisor/reports">
                    <i class="fas fa-file-chart-line"></i>
                    <span>Laporan Global</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/supervisor/users/create">
                    <i class="fas fa-user-plus"></i>
                    <span>Kelola Akun PIC</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/supervisor/profile">
                    <i class="fas fa-user-cog"></i>
                    <span>Profil & Pengaturan</span>
                </a>
            </li>
            
        </ul>
    @endif

    <!-- SUPERADMIN -->
    @if (in_array(auth()->user()->role, ['superadmin']))
        <h6><i class="fas fa-user-crown me-2"></i> MENU SUPER ADMIN</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/superadmin">
                    <span>Dashboard Admin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/superadmin/users">
                    <i class="fas fa-users-cog"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/superadmin/divisions">
                    <i class="fas fa-sitemap"></i>
                    <span>Manajemen Divisi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/superadmin/monitoring">
                    <i class="fas fa-desktop"></i>
                    <span>Monitoring Sistem</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/superadmin/audit">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Audit Aktivitas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" href="/superadmin/notifications">
                    <div>
                        <i class="fas fa-bell"></i>
                        <span>Notifikasi</span>
                    </div>
                    <span class="badge bg-danger text-white">{{ auth()->user()->unreadNotifications()->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/superadmin/profile">
                    <i class="fas fa-user-cog"></i>
                    <span>Profil & Pengaturan</span>
                </a>
            </li>
        </ul>
    @endif
</aside>

<!-- Main Content -->
<main class="content-area">
    <div class="content-header">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"></a></li>
                @yield('breadcrumb', '')
            </ol>
        </nav>
    </div>
    
    @yield('content')
    
    <!-- Footer -->
    <footer class="app-footer mt-5">
        <div class="container-fluid">
            <p class="mb-0">
                &copy; 2026 Ciptatech. 
                <span class="d-none d-md-inline">Versi 2.1.0 | Status: <span class="text-success">Production</span></span>
            </p>
        </div>
    </footer>
</main>

<nav class="bottom-nav" id="bottomNav">
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Pusher + Echo (optional - requires PUSHER_* env) -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.4/dist/echo.iife.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
     
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === currentUrl) {
                link.classList.add('active');
            }
        });
        
        const activeLinks = document.querySelectorAll('.nav-link.active');
        if (activeLinks.length === 0 && navLinks.length > 0) {
            navLinks[0].classList.add('active');
        }

        function generateBottomNav() {
            const bottomNav = document.getElementById('bottomNav');
            if (!bottomNav || window.innerWidth > 992) return;
            
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

            const mainLinks = Array.from(sidebarLinks).slice(0, 6);
            
            bottomNav.innerHTML = '';
            
            mainLinks.forEach(link => {
                const icon = link.querySelector('i').className;
                const text = link.querySelector('span').textContent.trim();
                const href = link.getAttribute('href');
                const isActive = link.classList.contains('active');
                
                const bottomNavItem = document.createElement('a');
                bottomNavItem.className = `bottom-nav-item ${isActive ? 'active' : ''}`;
                bottomNavItem.href = href;
                bottomNavItem.innerHTML = `
                    <i class="${icon}"></i>
                    <span>${text}</span>
                `;
                
                bottomNav.appendChild(bottomNavItem);
            });
        }
        generateBottomNav();
        
        window.addEventListener('resize', generateBottomNav);

        // Load notifications into header dropdown via AJAX
        const notifBtn = document.getElementById('notifDropdownBtn');
        const notifList = document.getElementById('notifDropdownList');
        const notifBadge = document.getElementById('notifBadge');

        async function loadNotifications() {
            try {
                // Use the JSON API endpoint we'll create to fetch recent notifications
                const apiRes = await fetch(location.origin + '/api/notifications');
                if (!apiRes.ok) throw new Error('Failed to fetch');
                const data = await apiRes.json();

                if (!data || data.length === 0) {
                    notifList.innerHTML = '<div class="text-center text-muted py-2">Belum ada notifikasi</div>';
                    notifBadge.textContent = 0;
                    return;
                }

                notifList.innerHTML = '';
                data.forEach(n => {
                    const li = document.createElement('li');
                    li.className = 'mb-2';
                    li.innerHTML = `
                        <a href="${location.origin}/${n.role.toLowerCase()}/notifications" class="d-flex justify-content-between align-items-start text-decoration-none text-dark">
                            <div>
                                <div class="fw-bold">${n.data.title}</div>
                                <div class="text-muted small">${n.data.message}</div>
                            </div>
                            <div class="text-muted small">${new Date(n.created_at).toLocaleString()}</div>
                        </a>
                    `;
                    notifList.appendChild(li);
                });

                notifBadge.textContent = data.filter(x => !x.read_at).length;
            } catch (e) {
                console.error(e);
            }
        }

        if (notifBtn) {
            notifBtn.addEventListener('click', loadNotifications);
        }
    });
</script>

<script>
    // Real-time notification listening (if pusher is configured)
    (function(){
        const pusherKey = '{{ config('broadcasting.connections.pusher.key') ?? env('PUSHER_APP_KEY') }}';
        const pusherCluster = '{{ config('broadcasting.connections.pusher.options.cluster') ?? env('PUSHER_APP_CLUSTER') }}';
        const broadcaster = '{{ config('broadcasting.default') }}';

        if (!pusherKey || broadcaster !== 'pusher') {
            return;
        }

        try {
            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: pusherKey,
                cluster: pusherCluster,
                forceTLS: true,
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            });

            const userId = '{{ auth()->id() }}';
            if (userId) {
                window.Echo.private('App.Models.User.' + userId)
                    .notification(function(notification) {
                        // Increment any badge counts
                        document.querySelectorAll('.nav-link .badge').forEach(el => {
                            const n = parseInt(el.textContent) || 0;
                            el.textContent = n + 1;
                        });

                        // Optional: show browser alert / toast
                        alert('Notifikasi baru: ' + (notification.title || notification.message || 'Anda menerima notifikasi'));
                    });
            }
        } catch (e) {
            console.error('Echo init failed', e);
        }
    })();
</script>

</body>
</html>