@extends('layouts.app')

@section('title', 'Monitoring Sistem')

@section('content')
<div class="monitoring-wrapper py-3">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1">
                <i class="fa-solid fa-chart-line text-primary me-2"></i>
                Monitoring Sistem
            </h4>
            <p class="text-muted mb-0">Overview performa dan aktivitas sistem secara real-time</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh Data
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase mb-2">Total Pengguna</h6>
                            <h2 class="fw-bold mb-0">{{ $total_users }}</h2>
                        </div>
                        <div class="stat-icon bg-blue-light p-3 rounded-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success small">
                            <i class="fas fa-check me-1"></i> {{ $active_users }} Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase mb-2">Total Tugas</h6>
                            <h2 class="fw-bold mb-0">{{ $total_tasks }}</h2>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-list-check fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                         Seluruh divisi
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase mb-2">Penyelesaian</h6>
                            <h2 class="fw-bold mb-0">{{ $completion_rate }}%</h2>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-circle-check fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ $completion_rate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small text-uppercase mb-2">Waktu Sistem</h6>
                            <h2 class="fw-bold fs-4 mb-0" id="system-time">-- : --</h2>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                        {{ now()->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-history text-muted me-2"></i>
                            Audit Trail / Aktivitas Terbaru
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="py-3 ps-4" style="width: 200px;">Waktu</th>
                                    <th class="py-3">User</th>
                                    <th class="py-3">Aktivitas</th>
                                    <th class="py-3 text-end pe-4">Sifat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ $activity->created_at->format('d/m/Y H:i') }}</span>
                                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle text-center me-2" style="width: 32px; height: 32px; line-height: 32px;">
                                                <i class="fas fa-user-circle text-muted"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">{{ $activity->causer->name ?? 'System' }}</span>
                                                <small class="text-muted">{{ $activity->causer->role ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">{{ $activity->description }}</span>
                                            @if($activity->subject_type)
                                                <small class="text-muted">
                                                    {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        @php
                                            $color = 'primary';
                                            $desc = strtolower($activity->description);
                                            if (Str::contains($desc, ['login', 'logout'])) $color = 'info';
                                            if (Str::contains($desc, ['create', 'store', 'add'])) $color = 'success';
                                            if (Str::contains($desc, ['update', 'edit', 'change', 'toggle'])) $color = 'warning';
                                            if (Str::contains($desc, ['delete', 'remove', 'destroy'])) $color = 'danger';
                                        @endphp
                                        <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} border border-{{ $color }} border-opacity-25 px-2 py-1 rounded">
                                            {{ strtoupper($activity->log_name ?? 'DEFAULT') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="py-4">
                                            <i class="fas fa-info-circle fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">Belum ada aktivitas yang tercatat</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-3 px-4">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-blue-light { background-color: rgba(13, 110, 253, 0.1); }
    
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); }
    
    .table thead th {
        font-weight: 600;
        letter-spacing: 0.5px;
        border-top: none;
    }
    
    .avatar-sm { font-size: 1.2rem; }
    
    .badge { font-size: 0.75rem; }

    .monitoring-wrapper .pagination {
        margin-bottom: 0;
    }
</style>

<script>
    function updateTime() {
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2, '0') + ' : ' + 
                       now.getMinutes().toString().padStart(2, '0');
        const clockEl = document.getElementById('system-time');
        if (clockEl) clockEl.innerText = timeStr;
    }
    
    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection
