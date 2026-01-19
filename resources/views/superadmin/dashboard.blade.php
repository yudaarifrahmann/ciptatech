@extends('layouts.app')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="superadmin-dashboard-wrapper py-3">
    <!-- Header Section -->
    <div class="superadmin-dashboard-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-gauge-high fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Dashboard Superadmin</h4>
                        <p class="text-muted mb-0">Overview sistem lengkap dengan kontrol penuh</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-sync-alt me-1"></i>Refresh Data
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-cog me-1"></i>System Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total User</h6>
                        <h2 class="display-6 fw-bold mb-0 text-primary">{{ $totalUsers }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-user me-1"></i>Admin: {{ $usersByRole['superadmin'] }}
                            </span>
                            <span class="badge bg-success bg-opacity-10 text-success ms-1">
                                <i class="fas fa-user-tie me-1"></i>Supervisor: {{ $usersByRole['supervisor'] }}
                            </span>
                            <span class="badge bg-info bg-opacity-10 text-info ms-1">
                                <i class="fas fa-user-check me-1"></i>PIC: {{ $usersByRole['PIC'] }}
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <div class="icon-wrapper bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span class="text-success">User aktif: {{ $onlineUsers }}</span>
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Divisi</h6>
                        <h2 class="display-6 fw-bold mb-0 text-success">{{ $totalDivisions }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle me-1"></i>Aktif: {{ $activeDivisions }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">
                                <i class="fas fa-pause-circle me-1"></i>Nonaktif: {{ $inactiveDivisions }}
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <div class="icon-wrapper bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-building fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-chart-line text-info me-1"></i>
                        <span class="text-info">{{ $activeDivisions }} divisi</span> dengan tugas aktif
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Laporan</h6>
                        <h2 class="display-6 fw-bold mb-0 text-warning">{{ $totalReports }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check me-1"></i>Disetujui: {{ $approvedReports }}
                            </span>
                            <span class="badge bg-warning bg-opacity-10 text-warning ms-1">
                                <i class="fas fa-clock me-1"></i>Menunggu: {{ $pendingReports }}
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <div class="icon-wrapper bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-file-alt fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        Total laporan: <strong>{{ $totalReports }}</strong>
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Aktivitas Sistem</h6>
                        <h2 class="display-6 fw-bold mb-0 text-info">{{ $totalUsers }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-bolt me-1"></i>Online: {{ $onlineUsers }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">
                                <i class="fas fa-moon me-1"></i>Offline: {{ $offlineUsers }}
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <div class="icon-wrapper bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-server fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-circle text-success me-1"></i>
                        Sistem <strong class="text-success">stabil</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- System Overview -->
    <div class="row g-4">
        <!-- Recent Activity -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="fas fa-history me-2 text-primary"></i>
                                Aktivitas Terbaru
                            </h5>
                            <p class="text-muted small mb-0">Log aktivitas sistem 24 jam terakhir</p>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-download me-1"></i>Export Log
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                <p class="text-muted small mb-0">{{ $activity['description'] }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $activity['time'] }} • Oleh: {{ $activity['author'] }}
                                </small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Tidak ada aktivitas terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list me-1"></i>Lihat Semua Aktivitas
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions & System Health -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Aksi Cepat
                    </h6>
                    <p class="text-muted small mb-0">Fungsi sistem utama</p>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <div class="row g-2">
                            <div class="col-6">
                                <button class="btn btn-outline-primary w-100 h-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-user-plus fa-2x mb-2"></i>
                                    <span class="small">Tambah User</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-success w-100 h-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-building fa-2x mb-2"></i>
                                    <span class="small">Kelola Divisi</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-info w-100 h-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-cog fa-2x mb-2"></i>
                                    <span class="small">System Config</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-warning w-100 h-100 p-3 d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                    <span class="small">Analytics</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="alert alert-info border-0 mb-0 py-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Sistem terakhir diupdate: 03 Jan 2026 10:30</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Metrics -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Metrik Sistem 7 Hari Terakhir
                    </h5>
                    <p class="text-muted small mb-0">Trend penggunaan dan aktivitas</p>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="metric-item">
                                <div class="metric-value text-primary fw-bold fs-4">{{ $metrics['total_logins'] }}</div>
                                <div class="metric-label text-muted small">Total Login</div>
                                <div class="metric-trend text-success">
                                    <i class="fas fa-arrow-up me-1"></i>8.5%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="metric-item">
                                <div class="metric-value text-success fw-bold fs-4">{{ $metrics['new_reports'] }}</div>
                                <div class="metric-label text-muted small">Laporan Baru</div>
                                <div class="metric-trend text-success">
                                    <i class="fas fa-arrow-up me-1"></i>12.3%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="metric-item">
                                <div class="metric-value text-warning fw-bold fs-4">{{ $metrics['completed_tasks'] }}</div>
                                <div class="metric-label text-muted small">Task Selesai</div>
                                <div class="metric-trend text-danger">
                                    <i class="fas fa-arrow-down me-1"></i>2.1%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="metric-item">
                                <div class="metric-value text-info fw-bold fs-4">{{ $metrics['system_uptime'] }}%</div>
                                <div class="metric-label text-muted small">System Uptime</div>
                                <div class="metric-trend text-success">
                                    <i class="fas fa-check-circle me-1"></i>Stabil
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .superadmin-dashboard-wrapper {
        padding: 1rem 0;
    }
    
    .superadmin-dashboard-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 12px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
    }
    
    .header-icon {
        flex-shrink: 0;
    }
    
    .icon-wrapper {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-card {
        transition: transform 0.2s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .stat-card .display-6 {
        font-size: 3rem;
        line-height: 1;
    }
    
    .stat-icon {
        flex-shrink: 0;
    }
    
    .card {
        border-radius: 12px;
    }
    
    .activity-timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .activity-timeline:before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #e9ecef, #dee2e6, #e9ecef);
    }
    
    .activity-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .activity-icon {
        position: absolute;
        left: -40px;
        top: 0;
        width: 40px;
        height: 40px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    
    .activity-content {
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #f1f1f1;
    }
    
    .system-health-items .progress {
        border-radius: 3px;
    }
    
    .health-item {
        padding: 0.5rem 0;
    }
    
    .quick-actions .btn {
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .quick-actions .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .metric-item {
        padding: 1rem;
        border-radius: 8px;
        background: rgba(248, 249, 250, 0.5);
        transition: all 0.2s ease;
    }
    
    .metric-item:hover {
        background: rgba(248, 249, 250, 1);
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    
    .metric-value {
        font-size: 2.5rem;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    .metric-trend {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .superadmin-dashboard-header {
            padding: 1.5rem;
        }
        
        .icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .icon-wrapper i {
            font-size: 1.5rem;
        }
        
        .stat-card {
            padding: 1.5rem !important;
        }
        
        .stat-card .display-6 {
            font-size: 2.5rem;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .header-actions .btn {
            flex: 1;
        }
        
        .activity-timeline {
            padding-left: 30px;
        }
        
        .activity-timeline:before {
            left: 15px;
        }
        
        .activity-icon {
            left: -30px;
            width: 30px;
            height: 30px;
        }
        
        .activity-icon i {
            font-size: 0.875rem;
        }
        
        .quick-actions .btn {
            padding: 1rem 0.5rem !important;
        }
        
        .metric-value {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .superadmin-dashboard-wrapper {
            padding: 0.5rem;
        }
        
        .superadmin-dashboard-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .row.g-4 {
            margin-top: 1rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        .activity-content {
            padding: 0.75rem 0.5rem;
        }
        
        .stat-card .display-6 {
            font-size: 2rem;
        }
        
        .metric-item {
            padding: 0.75rem 0.5rem;
        }
        
        .metric-value {
            font-size: 1.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Refresh data button
        const refreshBtn = document.querySelector('.btn-outline-primary');
        if (refreshBtn && refreshBtn.textContent.includes('Refresh')) {
            refreshBtn.addEventListener('click', function() {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Refreshing...';
                this.disabled = true;
                
                // Reload page to refresh data
                setTimeout(() => {
                    location.reload();
                }, 1500);
            });
        }
        
        // System settings button
        const settingsBtn = document.querySelector('.btn-primary');
        if (settingsBtn && settingsBtn.textContent.includes('System Settings')) {
            settingsBtn.addEventListener('click', function() {
                console.log('Opening system settings...');
                alert('System settings panel akan dibuka');
            });
        }
        
        // Quick action buttons
        const quickActions = document.querySelectorAll('.quick-actions .btn');
        quickActions.forEach(button => {
            button.addEventListener('click', function() {
                const action = this.querySelector('span').textContent;
                console.log(`Quick action: ${action}`);
                
                // Navigate based on action
                switch(action.trim()) {
                    case 'Tambah User':
                        window.location.href = '/superadmin/users/create';
                        break;
                    case 'Kelola Divisi':
                        window.location.href = '/superadmin/divisions';
                        break;
                    case 'System Config':
                        alert('Membuka konfigurasi sistem');
                        break;
                    case 'Analytics':
                        alert('Membuka dashboard analitik');
                        break;
                }
            });
        });
        
        // Activity item click handlers
        const activityItems = document.querySelectorAll('.activity-item');
        activityItems.forEach(item => {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function() {
                const activityTitle = this.querySelector('h6').textContent;
                console.log(`View activity details: ${activityTitle}`);
                // In real app, this would open activity detail modal
            });
        });
        
        // Export log button
        const exportLogBtn = document.querySelector('.btn-outline-secondary');
        if (exportLogBtn && exportLogBtn.textContent.includes('Export Log')) {
            exportLogBtn.addEventListener('click', function() {
                console.log('Exporting system logs...');
                showToast('Log berhasil diekspor', 'info');
            });
        }
        
        // Helper function to show toast notifications
        function showToast(message, type = 'info') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'warning' ? 'warning' : type === 'danger' ? 'danger' : 'info'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'danger' ? 'times-circle' : 'info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            // Add to container
            const container = document.querySelector('.superadmin-dashboard-wrapper');
            if (!container.querySelector('.toast-container')) {
                const toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                container.appendChild(toastContainer);
            }
            
            const toastContainer = container.querySelector('.toast-container');
            toastContainer.appendChild(toast);
            
            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', function () {
                toast.remove();
            });
        }
        
        // Health status color coding
        const healthBars = document.querySelectorAll('.system-health-items .progress-bar');
        healthBars.forEach(bar => {
            const width = parseInt(bar.style.width);
            if (width > 90) {
                bar.className = 'progress-bar bg-success';
            } else if (width > 80) {
                bar.className = 'progress-bar bg-warning';
            } else if (width > 70) {
                bar.className = 'progress-bar bg-info';
            } else {
                bar.className = 'progress-bar bg-danger';
            }
        });
    });
</script>
@endsection