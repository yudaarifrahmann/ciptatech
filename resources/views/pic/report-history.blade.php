@extends('layouts.app')

@section('title', 'Riwayat Laporan')

@section('content')
<div class="history-wrapper py-3">
    <!-- Header -->
    <div class="history-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-clock-rotate-left fa-2x text-info"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Riwayat Laporan</h4>
                        <p class="text-muted mb-0">Track semua laporan tugas yang telah dikirim</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <div class="d-flex flex-wrap gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Status</a></li>
                            <li><a class="dropdown-item" href="#">Disetujui</a></li>
                            <li><a class="dropdown-item" href="#">Menunggu</a></li>
                            <li><a class="dropdown-item" href="#">Revisi</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar me-1"></i>Periode
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                            <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                            <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                            <li><a class="dropdown-item" href="#">Kustom</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Laporan</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
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
                            <h6 class="text-muted mb-1">Selesai</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['selesai'] }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Reviews</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['review'] }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-danger">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Perbaikan</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['revisi'] }}</h3>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-redo fa-2x text-danger opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-history me-2"></i>Daftar Riwayat
                    </h5>
                    <p class="text-muted small mb-0">Menampilkan semua laporan yang telah dikirim</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 shadow-none" placeholder="Cari laporan...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-arrow-rotate-right"></i>
                        </button>
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
                            <th>Tugas</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Feedback Admin</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
@forelse ($reports as $report)
<tr>
    {{-- TANGGAL --}}
    <td class="ps-4">
        <div class="d-flex flex-column">
            <strong>{{ $report->created_at->format('Y-m-d') }}</strong>
            <small class="text-muted">{{ $report->created_at->format('H:i') }}</small>
        </div>
    </td>

    {{-- TUGAS --}}
    <td>
        <strong class="d-block">{{ $report->task_name }}</strong>
        <small class="text-muted">
            {{ Str::limit($report->description, 40) ?? '-' }}
        </small>
    </td>

    {{-- PROGRESS --}}
    <td>
        <small class="fw-bold">{{ $report->progress }}%</small>
        <div class="progress" style="height:6px">
            <div class="progress-bar
                {{ $report->progress < 30 ? 'bg-danger' :
                   ($report->progress < 70 ? 'bg-warning' :
                   ($report->progress < 100 ? 'bg-info' : 'bg-success')) }}"
                style="width: {{ $report->progress }}%">
            </div>
        </div>
    </td>

    {{-- STATUS --}}
    <td>
        @php
            $statusMap = [
                'draft' => ['secondary', 'Draft'],
                'progress' => ['info', 'Progress'],
                'menunggu review' => ['warning', 'Menunggu Review'],
                'revisi' => ['danger', 'Perbaikan'],
                'perbaikan' => ['danger', 'Perbaikan'],
                'selesai' => ['success', 'Selesai'],
            ];
            [$color, $label] = $statusMap[$report->status];
        @endphp

        <span class="badge bg-{{ $color }} bg-opacity-10
                     text-{{ $color }} border border-{{ $color }}
                     border-opacity-25 px-3 py-2 rounded-pill">
            {{ $label }}
        </span>
    </td>

    {{-- FEEDBACK --}}
    <td>
        <span class="text-muted fst-italic">
            {{ $report->feedback ?? 'Belum ada feedback' }}
        </span>
    </td>

    {{-- AKSI --}}
    <td class="text-end pe-4">
        <div class="btn-group">
            <a href="{{ route('pic.report.show', $report->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-eye"></i>
            </a>

            @if ($report->file_path)
            <a href="{{ asset('storage/'.$report->file_path) }}"
               class="btn btn-outline-info btn-sm" target="_blank">
                <i class="fas fa-download"></i>
            </a>
            @endif

            @if ($report->status !== 'selesai' && $report->status !== 'menunggu review')
            <a href="{{ route('pic.report.edit', $report->id) }}" class="btn btn-outline-warning btn-sm">
                <i class="fas fa-edit"></i>
            </a>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-4 text-muted">
        Belum ada laporan
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
                    <p class="text-muted small mb-0">
    Menampilkan {{ $reports->count() }} dari {{ $reports->total() }} laporan
</p>

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

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card border-0 bg-light">
                <div class="card-body p-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <i class="fas fa-file-export text-primary me-2"></i>
                            <div>
                                <small class="fw-bold">Ekspor Data</small>
                                <small class="text-muted d-block">Download riwayat laporan dalam berbagai format</small>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-file-excel me-1"></i> Excel
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </button>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-file-csv me-1"></i> CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .history-wrapper {
        padding: 1rem 0;
    }
    
    .history-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 12px;
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
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
    }
    
    .stat-icon {
        opacity: 0.8;
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
    
    .task-icon {
        width: 40px;
        height: 40px;
        background: rgba(13, 110, 253, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .progress {
        border-radius: 10px;
        min-width: 100px;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin-right: 4px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .feedback-content {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 2px;
        min-width: 32px;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .history-header {
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
            padding: 1rem !important;
        }
        
        .stat-icon i {
            font-size: 1.5rem !important;
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
            overflow: hidden;
        }
        
        .table th, .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .btn-group {
            flex-wrap: nowrap;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .feedback-content {
            max-width: 150px;
        }
    }
    
    @media (max-width: 576px) {
        .history-wrapper {
            padding: 0.5rem;
        }
        
        .history-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card h3 {
            font-size: 1.5rem;
        }
        
        .card-header {
            padding: 1rem !important;
        }
        
        .card-body {
            padding: 0 !important;
        }
        
        .table td {
            padding: 0.625rem 0.375rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
        }
        
        .task-icon {
            width: 32px;
            height: 32px;
            margin-right: 0.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.btn')) {
                    console.log('View details for row');
                }
            });
        });
    });
</script>
@endsection