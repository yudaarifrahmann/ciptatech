@extends('layouts.app')

@section('title', 'PIC Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <!-- Header -->

    <!-- Statistik -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <div class="icon-wrapper bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-tasks fa-lg text-primary"></i>
                        </div>
                    </div>
                    <div class="stats-content">
                        <h6 class="text-muted mb-1">Tugas Aktif</h6>
                        <p class="display-6 fw-bold mb-0 text-primary">
    {{ $stats['aktif'] }}
</p>
                        <small class="text-muted">Sedang berjalan</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 py-2">
                    <a href="#" class="text-decoration-none small">
                        Lihat detail <i class="fas fa-chevron-right fa-xs ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <div class="icon-wrapper bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-clock fa-lg text-warning"></i>
                        </div>
                    </div>
                    <div class="stats-content">
                        <h6 class="text-muted mb-1">Menunggu Review</h6>
                        <p class="display-6 fw-bold mb-0 text-warning">
    {{ $stats['review'] }}
</p>
                        <small class="text-muted">Perlu perhatian</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 py-2">
                    <a href="#" class="text-decoration-none small">
                        Tinjau sekarang <i class="fas fa-chevron-right fa-xs ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <div class="icon-wrapper bg-danger bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-redo fa-lg text-danger"></i>
                        </div>
                    </div>
                    <div class="stats-content">
                        <h6 class="text-muted mb-1">Revisi</h6>
                        <p class="display-6 fw-bold mb-0 text-danger">
    {{ $stats['revisi'] }}
</p>
                        <small class="text-muted">Perlu perbaikan</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 py-2">
                    <a href="#" class="text-decoration-none small">
                        Perbaiki <i class="fas fa-chevron-right fa-xs ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-chart-line me-2"></i>Progress Tugas
            </h5>
            <p class="text-muted small mb-0">Status terkini dari tugas yang sedang berjalan</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Nama Tugas</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Status Laporan</th>
                            <th scope="col" class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
@forelse ($reports as $report)
<tr>
    <td class="ps-4">
        <div class="d-flex align-items-center">
            <div class="task-icon me-3">
                <i class="fas fa-tasks text-primary"></i>
            </div>
            <div>
                <strong>{{ $report->task_name }}</strong><br>
                <small class="text-muted">
                    {{ $report->created_at->format('d M Y') }}
                </small>
            </div>
        </div>
    </td>

    <td>
        <div class="progress" style="height:8px">
            <div class="progress-bar
                {{ $report->progress < 30 ? 'bg-danger' :
                   ($report->progress < 70 ? 'bg-warning' :
                   ($report->progress < 100 ? 'bg-info' : 'bg-success')) }}"
                style="width: {{ $report->progress }}%">
            </div>
        </div>
        <small class="fw-bold">{{ $report->progress }}%</small>
    </td>

    <td>
        @php
            $statusMap = [
                'progress' => ['info', 'Progress'],
                'menunggu review' => ['warning', 'Menunggu Review'],
                'revisi' => ['danger', 'Revisi'],
                'selesai' => ['success', 'Selesai'],
            ];

            [$color, $label] = $statusMap[$report->status] ?? ['secondary', $report->status];
        @endphp

        <span class="badge bg-{{ $color }} bg-opacity-10
                     text-{{ $color }} border border-{{ $color }}
                     border-opacity-25 px-3 py-2 rounded-pill">
            {{ $label }}
        </span>
    </td>

    <td class="text-end pe-4">
        <a href="{{ route('pic.report.history') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-eye"></i>
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center text-muted py-4">
        Belum ada laporan
    </td>
</tr>
@endforelse
</tbody>

                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-end">
                <a href="{{ route('pic.report.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus me-1"></i> Tugas Baru
</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="alert alert-info border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-lg me-3"></i>
                    <div>
                        <strong>Tips Produktivitas:</strong> Tinjau tugas yang menunggu review untuk mempercepat proses.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-light border shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-bell fa-lg me-3 text-primary"></i>
                    <div>
                        <strong>Notifikasi:</strong> Anda memiliki 1 tugas yang memerlukan revisi.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper {
        padding: 1.5rem 0;
    }
    
    .dashboard-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    
    .stats-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 12px;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .icon-wrapper {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        color: #6c757d;
        border-top: none;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem;
    }
    
    .progress {
        border-radius: 10px;
        min-width: 150px;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
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
    
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .date-display {
            margin-top: 1rem;
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .stats-card .card-body {
            padding: 1.25rem;
        }
        
        .display-6 {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-wrapper {
            padding: 1rem 0;
        }
        
        .table td, .table th {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>
@endsection