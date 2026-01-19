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
                            <h2 class="fw-bold mb-0">{{ $totalReports }}</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>{{ $approvedReports }} disetujui
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
                            <h2 class="fw-bold mb-0">{{ $approvedReports }}</h2>
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>{{ $totalReports > 0 ? round(($approvedReports / $totalReports) * 100) : 0 }}% approval rate
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
                            <h2 class="fw-bold mb-0">{{ $pendingRevision }}</h2>
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
                            <h2 class="fw-bold mb-0">{{ $totalDivisions }}</h2>
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
                                @forelse($divisions as $division)
                                @php
                                    $statusColorMap = [
                                        'optimal' => ['bg' => 'rgba(13, 202, 240, 0.1)', 'border' => '#0cc7f0', 'text' => '#0cc7f0', 'icon' => 'fa-tachometer-alt', 'label' => 'Optimal', 'icon-bg' => 'rgba(13, 202, 240, 0.1)'],
                                        'on-track' => ['bg' => 'rgba(25, 135, 84, 0.1)', 'border' => '#198754', 'text' => '#198754', 'icon' => 'fa-check-circle', 'label' => 'On Track', 'icon-bg' => 'rgba(25, 135, 84, 0.1)'],
                                        'attention' => ['bg' => 'rgba(255, 193, 7, 0.1)', 'border' => '#ffc107', 'text' => '#ffc107', 'icon' => 'fa-exclamation-triangle', 'label' => 'Perlu Perhatian', 'icon-bg' => 'rgba(255, 193, 7, 0.1)'],
                                        'critical' => ['bg' => 'rgba(220, 53, 69, 0.1)', 'border' => '#dc3545', 'text' => '#dc3545', 'icon' => 'fa-exclamation-circle', 'label' => 'Kritis', 'icon-bg' => 'rgba(220, 53, 69, 0.1)']
                                    ];
                                    $colors = $statusColorMap[$division->status] ?? $statusColorMap['critical'];
                                    $divisionIcons = [
                                        'Multimedia' => 'fa-photo-video',
                                        'Software Host' => 'fa-server',
                                        'IT Support' => 'fa-headset',
                                    ];
                                    $divisionIcon = $divisionIcons[$division->name] ?? 'fa-network-wired';
                                    $buttonIcon = $division->status === 'attention' ? 'fa-exclamation-circle' : ($division->status === 'on-track' ? 'fa-eye' : 'fa-chart-bar');
                                    $buttonText = $division->status === 'attention' ? 'Review' : ($division->status === 'on-track' ? 'View' : 'Analytics');
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="division-icon me-3">
                                                <div class="icon-wrapper p-2 rounded-circle" style="background-color: {{ $colors['icon-bg'] }};">
                                                    <i class="fas {{ $divisionIcon }}" style="color: {{ $colors['text'] }};"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="d-block">{{ $division->name }}</strong>
                                                <small class="text-muted">{{ $division->active_projects }} proyek aktif</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper" style="min-width: 150px;">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>{{ $division->avg_progress }}%</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $division->avg_progress }}%; background-color: {{ $colors['text'] }};" aria-valuenow="{{ $division->avg_progress }}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge px-3 py-2 rounded-pill" style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }}; border-opacity: 0.25;">
                                            <i class="fas {{ $division->status_icon }} me-1"></i>{{ $division->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm division-action-btn" data-status="{{ $division->status }}" style="border: 1px solid {{ $colors['border'] }}; color: {{ $colors['text'] }};">
                                            <i class="fas {{ $buttonIcon }} me-1"></i>{{ $buttonText }}
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="text-muted mb-0">Tidak ada divisi yang aktif</p>
                                    </td>
                                </tr>
                                @endforelse
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
                        @forelse($pendingReviews as $review)
                        <a href="#" class="list-group-item list-group-item-action border-0 py-2 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold">{{ $review->task_name }}</small>
                                    <div class="text-muted small">{{ $review->division_name ?? 'N/A' }} • Deadline: {{ $review->deadline }}</div>
                                </div>
                                <span class="badge bg-warning">Baru</span>
                            </div>
                        </a>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Tidak ada laporan yang menunggu review</p>
                        </div>
                        @endforelse
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
                        @php
                            $total = $reportStats['approved'] + $reportStats['pending'] + $reportStats['revision'];
                            $approvedPercent = $total > 0 ? ($reportStats['approved'] / $total) * 100 : 0;
                            $pendingPercent = $total > 0 ? ($reportStats['pending'] / $total) * 100 : 0;
                            $revisionPercent = $total > 0 ? ($reportStats['revision'] / $total) * 100 : 0;
                        @endphp
                        <div class="doughnut-chart mx-auto mb-3" style="width: 150px; height: 150px; position: relative;">
                            <div class="chart-segment" style="
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                                background: conic-gradient(
                                    #0d6efd 0% {{ $approvedPercent }}%,
                                    #ffc107 {{ $approvedPercent }}% {{ $approvedPercent + $pendingPercent }}%,
                                    #dc3545 {{ $approvedPercent + $pendingPercent }}% 100%
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
                                    <div class="fw-bold">{{ $total }}</div>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="chart-legend">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #0d6efd; width: 12px; height: 12px; border-radius: 2px; margin: 0 auto 4px;"></div>
                                        <small class="d-block fw-bold">{{ $reportStats['approved'] }}</small>
                                        <small class="text-muted">Disetujui</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #ffc107; width: 12px; height: 12px; border-radius: 2px; margin: 0 auto 4px;"></div>
                                        <small class="d-block fw-bold">{{ $reportStats['pending'] }}</small>
                                        <small class="text-muted">Menunggu</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: #dc3545; width: 12px; height: 12px; border-radius: 2px; margin: 0 auto 4px;"></div>
                                        <small class="d-block fw-bold">{{ $reportStats['revision'] }}</small>
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
    
    .division-action-btn {
        border: 1px solid;
        transition: background-color 0.2s ease;
    }
    
    .division-action-btn:hover {
        border-color: inherit;
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
        // Color mapping for division statuses
        const statusColors = {
            'optimal': { border: '#0cc7f0', text: '#0cc7f0', bg: 'rgba(13, 202, 240, 0.1)' },
            'on-track': { border: '#198754', text: '#198754', bg: 'rgba(25, 135, 84, 0.1)' },
            'attention': { border: '#ffc107', text: '#ffc107', bg: 'rgba(255, 193, 7, 0.1)' },
            'critical': { border: '#dc3545', text: '#dc3545', bg: 'rgba(220, 53, 69, 0.1)' }
        };
        
        // Division action buttons hover effects
        const actionButtons = document.querySelectorAll('.division-action-btn');
        actionButtons.forEach(button => {
            const status = button.dataset.status;
            const colors = statusColors[status] || statusColors.critical;
            
            button.addEventListener('mouseenter', function() {
                this.style.backgroundColor = colors.bg;
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
            });
            
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const division = this.closest('tr').querySelector('strong').textContent;
                console.log(`View details for ${division}`);
            });
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