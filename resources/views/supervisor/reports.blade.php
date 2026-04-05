@extends('layouts.app')

@section('title', 'Laporan Global')

@section('content')
<div class="global-reports-wrapper py-3">
    <!-- Header Section -->
    <div class="global-reports-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-file-lines fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Riwayat & Laporan Global</h4>
                        <p class="text-muted mb-0">Analisis komprehensif semua laporan dari seluruh divisi</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="fas fa-file-excel me-1"></i>Export Excel
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-print me-1"></i>Print
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
                            <h6 class="text-muted mb-1">Total Laporan</h6>
                            <h2 class="fw-bold mb-0">{{ $total_reports }}</h2>
                            <small class="text-primary">
                                <i class="fas fa-calendar me-1"></i>Bulan ini
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-file-alt fa-2x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Disetujui</h6>
                            <h2 class="fw-bold mb-0">{{ $approved_count }}</h2>
                            <small class="text-success">
                                <i class="fas fa-chart-line me-1"></i>{{ $total_reports > 0 ? round(($approved_count / $total_reports) * 100) : 0 }}% approval rate
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
                            <h6 class="text-muted mb-1">Dalam Proses</h6>
                            <h2 class="fw-bold mb-0">{{ $pending_count }}</h2>
                            <small class="text-warning">
                                <i class="fas fa-clock me-1"></i>Perlu review
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-spinner fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Rata-rata Waktu</h6>
                            <h2 class="fw-bold mb-0">{{ $avg_response_time }}</h2>
                            <small class="text-info">
                                <i class="fas fa-business-time me-1"></i>hari/respon
                            </small>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-hourglass-half fa-2x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-1">
                <i class="fas fa-filter me-2 text-primary"></i>
                Filter Laporan
            </h5>
            <p class="text-muted small mb-0">Filter laporan berdasarkan kriteria tertentu</p>
        </div>
        <div class="card-body">
            <form action="{{ route('supervisor.reports') }}" method="GET" class="row g-3 mb-2" id="reportFilterForm">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-building me-1 text-primary"></i>
                        Divisi
                    </label>
                    <select class="form-select border-1 shadow-sm" name="division_id">
                        <option selected>Semua Divisi</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-calendar me-1 text-primary"></i>
                        Dari Tanggal
                    </label>
                    <div class="input-group">
                        <input type="date" class="form-control border-1 shadow-sm" name="date_from" value="{{ request('date_from') }}">
                        <span class="input-group-text bg-transparent">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-calendar-check me-1 text-primary"></i>
                        Sampai Tanggal
                    </label>
                    <div class="input-group">
                        <input type="date" class="form-control border-1 shadow-sm" name="date_to" value="{{ request('date_to') }}">
                        <span class="input-group-text bg-transparent">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-tag me-1 text-primary"></i>
                        Status
                    </label>
                    <select class="form-select border-1 shadow-sm" name="status">
                        <option selected>Semua Status</option>
                        @foreach(['Disetujui', 'Menunggu Review', 'Revisi', 'Ditolak'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-user me-1 text-primary"></i>
                        PIC
                    </label>
                    <select class="form-select border-1 shadow-sm" name="pic_id">
                        <option selected>Semua PIC</option>
                        @foreach($pics as $pic)
                            <option value="{{ $pic->id }}" {{ request('pic_id') == $pic->id ? 'selected' : '' }}>
                                {{ $pic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-search me-1 text-primary"></i>
                        Kata Kunci
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control border-1 shadow-sm" name="search" placeholder="Cari tugas atau deskripsi..." value="{{ request('search') }}">
                        <span class="input-group-text bg-transparent">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <div class="d-flex gap-2 h-100 align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('supervisor.reports') }}" class="btn btn-outline-secondary" id="resetFilter">
                            <i class="fas fa-redo me-1"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-table me-2 text-primary"></i>
                        Daftar Laporan Global
                    </h5>
                    <p class="text-muted small mb-0">Riwayat lengkap semua laporan yang telah diproses</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-2 small">Tampilkan:</span>
                        <select class="form-select form-select-sm w-auto">
                            <option selected>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">
                                <div class="d-flex align-items-center">
                                    <span>Tanggal</span>
                                    <button class="btn btn-link btn-sm p-0 ms-1">
                                        <i class="fas fa-sort text-muted"></i>
                                    </button>
                                </div>
                            </th>
                            <th>Divisi</th>
                            <th>Tugas</th>
                            <th>PIC</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <strong class="mb-1">{{ $task->created_at->format('Y-m-d') }}</strong>
                                    <small class="text-muted">{{ $task->created_at->format('H:i') }} WIB</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="division-icon me-2">
                                        <div class="icon-wrapper bg-primary bg-opacity-10 p-1 rounded-circle">
                                            <i class="fas fa-building text-primary fa-sm"></i>
                                        </div>
                                    </div>
                                    <strong>{{ $task->division->name ?? 'N/A' }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="task-info">
                                    <strong class="d-block mb-1">{{ $task->title }}</strong>
                                    <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="pic-info">
                                    <div class="avatar-placeholder bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-info"></i>
                                    </div>
                                    <div class="d-inline-block">
                                        <strong>{{ $task->latestSubmission->pic->name ?? 'Belum ada' }}</strong>
                                        <div class="text-muted small">{{ $task->latestSubmission->pic->role ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $progress = 0;
                                    if ($task->status == 'approved') $progress = 100;
                                    elseif ($task->status == 'submitted') $progress = 80;
                                    elseif ($task->status == 'in_progress') $progress = 40;
                                    elseif ($task->status == 'assigned') $progress = 20;
                                @endphp
                                <div class="progress-wrapper" style="min-width: 100px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="fw-bold">{{ $progress }}%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar {{ $progress == 100 ? 'bg-success' : ($progress >= 80 ? 'bg-info' : 'bg-primary') }}" role="progressbar" 
                                             style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-secondary text-white',
                                        'assigned' => 'bg-info text-white',
                                        'in_progress' => 'bg-primary text-white',
                                        'submitted' => 'bg-warning text-dark',
                                        'approved' => 'bg-success text-white',
                                        'rejected' => 'bg-danger text-white',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'assigned' => 'Ditugaskan',
                                        'in_progress' => 'Progres',
                                        'submitted' => 'Menunggu Review',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak/Revisi',
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$task->status] ?? 'bg-secondary' }} px-3 py-2 rounded-pill">
                                    {{ $statusLabels[$task->status] ?? $task->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('supervisor.monitoring.show', $task->id) }}" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-file-circle-xmark fa-3x mb-3 d-block"></i>
                                    <p class="mb-0">Tidak ada laporan ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-2 mb-md-0">
                    <p class="text-muted small mb-0">Menampilkan {{ $tasks->firstItem() ?? 0 }} sampai {{ $tasks->lastItem() ?? 0 }} dari {{ $tasks->total() }} laporan</p>
                </div>
                <div class="pagination-wrapper">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 bg-primary bg-opacity-5 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chart-bar text-primary me-2 fa-lg"></i>
                        <div>
                            <small class="fw-bold d-block">Analisis Tersedia</small>
                            <small class="text-muted">Lihat analisis mendetail per divisi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-success bg-opacity-5 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-success me-2 fa-lg"></i>
                        <div>
                            <small class="fw-bold d-block">Waktu Respon</small>
                            <small class="text-muted">Rata-rata: {{ $avg_response_time }} hari per laporan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-info bg-opacity-5 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-download text-info me-2 fa-lg"></i>
                        <div>
                            <small class="fw-bold d-block">Ekspor Data</small>
                            <small class="text-muted">Download laporan lengkap</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .global-reports-wrapper {
        padding: 1rem 0;
    }
    
    .global-reports-header {
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
    
    .form-label {
        font-size: 0.875rem;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #86b7fe;
    }
    
    .division-icon .icon-wrapper {
        width: 32px;
        height: 32px;
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
    
    .avatar-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin-right: 4px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 2px;
        min-width: 32px;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .global-reports-header {
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
        
        .division-icon .icon-wrapper {
            width: 28px;
            height: 28px;
        }
        
        .task-info, .pic-info {
            min-width: 150px;
        }
        
        .btn-group {
            flex-wrap: nowrap;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .card-body .row.g-3 {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 576px) {
        .global-reports-wrapper {
            padding: 0.5rem;
        }
        
        .global-reports-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .row.g-3 {
            margin-bottom: 1rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        .card-body .col-lg-3, .card-body .col-lg-4 {
            margin-bottom: 1rem;
        }
        
        .table td {
            padding: 0.625rem 0.375rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
        }
        
        .progress-wrapper {
            min-width: 80px !important;
        }
        
        .avatar-placeholder {
            width: 28px !important;
            height: 28px !important;
            margin-right: 0.5rem !important;
        }
        
        .pic-info .text-muted {
            font-size: 0.75rem;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-2 .btn {
            width: 100% !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Reset is now handled by an <a> tag redirecting to the route
        
        const filterForm = document.getElementById('reportFilterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Applying filters...');
               
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    console.log('Filters applied successfully');
                }, 1000);
            });
        }
        
        const exportButtons = document.querySelectorAll('.btn-outline-primary, .btn-outline-success, .btn-primary');
        exportButtons.forEach(button => {
            if (button.textContent.includes('Export') || button.textContent.includes('Print')) {
                button.addEventListener('click', function() {
                    const action = this.textContent.trim();
                    console.log(`${action} report...`);
                    
                });
            }
        });
    
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.btn') && !e.target.closest('.badge')) {
                    const taskName = this.querySelector('.task-info strong').textContent;
                    const date = this.querySelector('td:first-child strong').textContent;
                    console.log(`View report details for ${taskName} (${date})`);
                }
            });
        });
        
        const statusBadges = document.querySelectorAll('.badge');
        statusBadges.forEach(badge => {
            if (badge.textContent.includes('Disetujui')) {
                badge.className = 'badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill';
            } else if (badge.textContent.includes('Menunggu')) {
                badge.className = 'badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill';
            } else if (badge.textContent.includes('Revisi')) {
                badge.className = 'badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill';
            }
        });
    });
</script>
@endsection