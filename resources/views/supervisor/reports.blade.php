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
                            <h2 class="fw-bold mb-0">156</h2>
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
                            <h2 class="fw-bold mb-0">128</h2>
                            <small class="text-success">
                                <i class="fas fa-chart-line me-1"></i>82% approval rate
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
                            <h2 class="fw-bold mb-0">18</h2>
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
                            <h2 class="fw-bold mb-0">2.3</h2>
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
            <form class="row g-3 mb-2" id="reportFilterForm">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-building me-1 text-primary"></i>
                        Divisi
                    </label>
                    <select class="form-select border-1 shadow-sm">
                        <option selected>Semua Divisi</option>
                        <option>Multimedia</option>
                        <option>Software Host</option>
                        <option>IT Support</option>
                        <option>Network</option>
                        <option>Hardware</option>
                        <option>Security</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-calendar me-1 text-primary"></i>
                        Dari Tanggal
                    </label>
                    <div class="input-group">
                        <input type="date" class="form-control border-1 shadow-sm" value="2026-01-01">
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
                        <input type="date" class="form-control border-1 shadow-sm" value="2026-01-03">
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
                    <select class="form-select border-1 shadow-sm">
                        <option selected>Semua Status</option>
                        <option>Disetujui</option>
                        <option>Menunggu Review</option>
                        <option>Revisi</option>
                        <option>Ditolak</option>
                    </select>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-user me-1 text-primary"></i>
                        PIC
                    </label>
                    <select class="form-select border-1 shadow-sm">
                        <option selected>Semua PIC</option>
                        <option>Andi</option>
                        <option>Budi</option>
                        <option>Siti</option>
                        <option>Cici</option>
                        <option>Dodi</option>
                    </select>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold mb-1">
                        <i class="fas fa-search me-1 text-primary"></i>
                        Kata Kunci
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control border-1 shadow-sm" placeholder="Cari tugas atau deskripsi...">
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
                        <button type="button" class="btn btn-outline-secondary" id="resetFilter">
                            <i class="fas fa-redo me-1"></i>
                            Reset
                        </button>
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
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <strong class="mb-1">2026-01-03</strong>
                                    <small class="text-muted">14:30 WIB</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="division-icon me-2">
                                        <div class="icon-wrapper bg-warning bg-opacity-10 p-1 rounded-circle">
                                            <i class="fas fa-server text-warning fa-sm"></i>
                                        </div>
                                    </div>
                                    <strong>Software Host</strong>
                                </div>
                            </td>
                            <td>
                                <div class="task-info">
                                    <strong class="d-block mb-1">Deploy Aplikasi</strong>
                                    <small class="text-muted">Update versi 2.1.0 ke production</small>
                                </div>
                            </td>
                            <td>
                                <div class="pic-info">
                                    <div class="avatar-placeholder bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-warning"></i>
                                    </div>
                                    <div class="d-inline-block">
                                        <strong>Siti</strong>
                                        <div class="text-muted small">DevOps Engineer</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="progress-wrapper" style="min-width: 100px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="fw-bold">100%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Disetujui
                                </span>
                                <div class="text-muted small mt-1">Oleh: Admin • 2 jam lalu</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" title="Download Laporan">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Additional sample rows -->
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <strong class="mb-1">2026-01-02</strong>
                                    <small class="text-muted">10:15 WIB</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="division-icon me-2">
                                        <div class="icon-wrapper bg-primary bg-opacity-10 p-1 rounded-circle">
                                            <i class="fas fa-photo-video text-primary fa-sm"></i>
                                        </div>
                                    </div>
                                    <strong>Multimedia</strong>
                                </div>
                            </td>
                            <td>
                                <div class="task-info">
                                    <strong class="d-block mb-1">Video Tutorial Produk</strong>
                                    <small class="text-muted">Editing final dan subtitles</small>
                                </div>
                            </td>
                            <td>
                                <div class="pic-info">
                                    <div class="avatar-placeholder bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div class="d-inline-block">
                                        <strong>Andi</strong>
                                        <div class="text-muted small">Video Editor</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="progress-wrapper" style="min-width: 100px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="fw-bold">85%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                             style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-clock me-1"></i> Menunggu Review
                                </span>
                                <div class="text-muted small mt-1">Sudah 1 hari</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <strong class="mb-1">2026-01-01</strong>
                                    <small class="text-muted">16:45 WIB</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="division-icon me-2">
                                        <div class="icon-wrapper bg-success bg-opacity-10 p-1 rounded-circle">
                                            <i class="fas fa-headset text-success fa-sm"></i>
                                        </div>
                                    </div>
                                    <strong>IT Support</strong>
                                </div>
                            </td>
                            <td>
                                <div class="task-info">
                                    <strong class="d-block mb-1">Maintenance Server</strong>
                                    <small class="text-muted">Backup database rutin</small>
                                </div>
                            </td>
                            <td>
                                <div class="pic-info">
                                    <div class="avatar-placeholder bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                    <div class="d-inline-block">
                                        <strong>Budi</strong>
                                        <div class="text-muted small">System Admin</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="progress-wrapper" style="min-width: 100px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="fw-bold">100%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Disetujui
                                </span>
                                <div class="text-muted small mt-1">Oleh: Supervisor • 2 hari lalu</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-2 mb-md-0">
                    <p class="text-muted small mb-0">Menampilkan 3 dari 156 laporan</p>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
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
                            <small class="text-muted">Rata-rata: 2.3 hari per laporan</small>
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
        
        const resetFilterBtn = document.getElementById('resetFilter');
        if (resetFilterBtn) {
            resetFilterBtn.addEventListener('click', function() {
                const form = document.getElementById('reportFilterForm');
                form.reset();
                console.log('Filter reset');
                
            });
        }
        
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