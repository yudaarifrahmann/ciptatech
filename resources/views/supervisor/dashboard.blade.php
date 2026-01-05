@extends('layouts.app')

@section('title', 'Dashboard Supervisor')

@section('content')
<div class="dashboard-wrapper py-3">
    <!-- Header Section -->
    <div class="dashboard-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-gauge-high fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Dashboard Supervisor</h4>
                        <p class="text-muted mb-0">Overview monitoring seluruh divisi dan laporan</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-download me-1"></i>Export Report
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Buat Task
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Laporan Masuk</h6>
                            <h2 class="fw-bold mb-0">42</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>12% dari bulan lalu
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-inbox fa-2x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pekerjaan Disetujui</h6>
                            <h2 class="fw-bold mb-0">28</h2>
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>67% approval rate
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-double fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Menunggu / Revisi</h6>
                            <h2 class="fw-bold mb-0">14</h2>
                            <small class="text-warning">
                                <i class="fas fa-clock me-1"></i>Perlu ditinjau
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock-rotate-left fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Divisi</h6>
                            <h2 class="fw-bold mb-0">8</h2>
                            <small class="text-info">
                                <i class="fas fa-users me-1"></i>Aktif semua
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-building fa-2x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Progress Summary -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                Ringkasan Progres Semua Divisi
                            </h5>
                            <p class="text-muted small mb-0">Monitoring perkembangan setiap divisi</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-calendar me-1"></i>Bulan Ini
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                                <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                <li><a class="dropdown-item" href="#">3 Bulan Terakhir</a></li>
                                <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Divisi</th>
                                    <th>Progress Rata-rata</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="division-icon me-3">
                                                <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-circle">
                                                    <i class="fas fa-photo-video text-primary"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="d-block">Multimedia</strong>
                                                <small class="text-muted">15 proyek aktif</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper" style="min-width: 150px;">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>75%</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>On Track
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>View
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="division-icon me-3">
                                                <div class="icon-wrapper bg-warning bg-opacity-10 p-2 rounded-circle">
                                                    <i class="fas fa-server text-warning"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="d-block">Software Host</strong>
                                                <small class="text-muted">10 proyek aktif</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper" style="min-width: 150px;">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>60%</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                     style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Perlu Perhatian
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-exclamation-circle me-1"></i>Review
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="division-icon me-3">
                                                <div class="icon-wrapper bg-success bg-opacity-10 p-2 rounded-circle">
                                                    <i class="fas fa-headset text-success"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="d-block">IT Support</strong>
                                                <small class="text-muted">8 proyek aktif</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper" style="min-width: 150px;">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>90%</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="fas fa-shield-alt me-1"></i>Stabil
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-chart-bar me-1"></i>Analytics
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Additional divisions -->
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="division-icon me-3">
                                                <div class="icon-wrapper bg-info bg-opacity-10 p-2 rounded-circle">
                                                    <i class="fas fa-network-wired text-info"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="d-block">Network</strong>
                                                <small class="text-muted">12 proyek aktif</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper" style="min-width: 150px;">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>80%</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-info" role="progressbar" 
                                                     style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="fas fa-tachometer-alt me-1"></i>Optimal
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-eye me-1"></i>View
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i>Lihat Semua Divisi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity & Charts -->
        <div class="col-lg-4">
            <!-- Pending Reviews -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-clock text-warning me-2"></i>
                        Menunggu Review
                    </h6>
                    <p class="text-muted small mb-0">Laporan yang perlu segera ditinjau</p>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action border-0 py-2 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">Implementasi Login</small>
                                    <div class="text-muted small">Multimedia • Deadline: 5 Jan</div>
                                </div>
                                <span class="badge bg-warning">Baru</span>
                            </div>
                        </a>
                        
                        <a href="#" class="list-group-item list-group-item-action border-0 py-2 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">Update Dashboard</small>
                                    <div class="text-muted small">Software Host • Deadline: 7 Jan</div>
                                </div>
                                <span class="badge bg-warning">2 hari</span>
                            </div>
                        </a>
                        
                        <a href="#" class="list-group-item list-group-item-action border-0 py-2 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">Maintenance Server</small>
                                    <div class="text-muted small">IT Support • Deadline: 10 Jan</div>
                                </div>
                                <span class="badge bg-secondary">1 minggu</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-2">
                    <a href="#" class="btn btn-outline-warning btn-sm w-100">
                        <i class="fas fa-external-link-alt me-1"></i>Review Semua
                    </a>
                </div>
            </div>
            
            <!-- Quick Stats Chart -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie text-info me-2"></i>
                        Statistik Laporan
                    </h6>
                    <p class="text-muted small mb-0">Distribusi status laporan</p>
                </div>
                <div class="card-body">
                    <div class="chart-placeholder text-center">
                        <div class="doughnut-chart mx-auto mb-3" style="width: 150px; height: 150px; position: relative;">
                            <div class="chart-segment" style="
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                                background: conic-gradient(
                                    #0d6efd 0% 67%,
                                    #ffc107 67% 86%,
                                    #dc3545 86% 100%
                                );
                            "></div>
                            <div class="chart-center" style="
                                position: absolute;
                                top: 20px;
                                left: 20px;
                                width: 110px;
                                height: 110px;
                                background: white;
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <div class="text-center">
                                    <div class="fw-bold">42</div>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="chart-legend">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #0d6efd; width: 12px; height: 12px; border-radius: 2px; margin: 0 auto 4px;"></div>
                                        <small class="d-block fw-bold">28</small>
                                        <small class="text-muted">Disetujui</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #ffc107; width: 12px; height: 12px; border-radius: 2px; margin: 0 auto 4px;"></div>
                                        <small class="d-block fw-bold">10</small>
                                        <small class="text-muted">Menunggu</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #dc3545; width: 12px; height: 12px; border-radius: 2px; margin: 0 auto 4px;"></div>
                                        <small class="d-block fw-bold">4</small>
                                        <small class="text-muted">Revisi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 bg-light shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <i class="fas fa-bullhorn text-primary me-2 fa-lg"></i>
                            <div>
                                <small class="fw-bold d-block">Update Terbaru</small>
                                <small class="text-muted">Meeting review kinerja divisi dijadwalkan Jumat, 10 Januari 2026 pukul 09:00 WIB</small>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-check me-1"></i>Tambahkan Kalender
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper {
        padding: 1rem 0;
    }
    
    .dashboard-header {
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
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    
    .stat-card h2 {
        font-size: 2.5rem;
        line-height: 1;
    }
    
    .stat-icon {
        opacity: 0.8;
    }
    
    .card {
        border-radius: 12px;
    }
    
    .division-icon .icon-wrapper {
        width: 45px;
        height: 45px;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        color: #6c757d;
        border-top: none;
        padding: 1rem;
        vertical-align: middle;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem;
        border-top: 1px solid #f1f1f1;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    
    .list-group-item {
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
    
    .chart-placeholder {
        padding: 1rem 0;
    }
    
    .legend-item {
        padding: 0.5rem 0;
    }
    
    @media (max-width: 768px) {
        .dashboard-header {
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
            padding: 1.25rem !important;
        }
        
        .stat-card h2 {
            font-size: 2rem;
        }
        
        .stat-icon i {
            font-size: 1.75rem !important;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .header-actions .btn {
            flex: 1;
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .table th, .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .doughnut-chart {
            width: 120px !important;
            height: 120px !important;
        }
        
        .chart-center {
            top: 15px !important;
            left: 15px !important;
            width: 90px !important;
            height: 90px !important;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-wrapper {
            padding: 0.5rem;
        }
        
        .dashboard-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .row.g-4 {
            margin-top: 1rem !important;
        }
        
        .card-header, .card-body, .card-footer {
            padding: 1rem !important;
        }
        
        .btn-sm {
            font-size: 0.75rem;
        }
        
        .division-icon .icon-wrapper {
            width: 40px;
            height: 40px;
            margin-right: 0.75rem;
        }
        
        .progress-wrapper {
            min-width: 120px !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.btn-outline-primary, .btn-outline-warning, .btn-outline-success, .btn-outline-info');
        viewButtons.forEach(button => {
            if (button.textContent.includes('View') || button.textContent.includes('Review') || button.textContent.includes('Analytics')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const division = this.closest('tr').querySelector('strong').textContent;
                    console.log(`View details for ${division}`);
                });
            }
        });
        
        const pendingItems = document.querySelectorAll('.list-group-item-action');
        pendingItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const taskName = this.querySelector('.fw-bold').textContent;
                console.log(`Review task: ${taskName}`);
            });
        });
  
        const badges = document.querySelectorAll('.badge');
        badges.forEach(badge => {
            if (badge.textContent.includes('Baru') || badge.textContent.includes('hari') || badge.textContent.includes('minggu')) {
                badge.setAttribute('data-bs-toggle', 'tooltip');
                badge.setAttribute('title', 'Klik untuk review');
            }
        });
        
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection