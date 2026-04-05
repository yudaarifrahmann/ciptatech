@extends('layouts.app')

@section('title', 'Audit Aktivitas')

@section('content')
<div class="audit-wrapper py-3">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1">
                <i class="fa-solid fa-clipboard-check text-primary me-2"></i>
                Audit Aktivitas
            </h4>
            <p class="text-muted mb-0">Riwayat lengkap seluruh tindakan yang dilakukan oleh pengguna di sistem</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('superadmin.audit') }}" method="GET" class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold small text-muted text-uppercase">Tipe Log</label>
                    <select class="form-select border-1 shadow-sm" name="log_name">
                        <option value="Semua Tipe" {{ request('log_name') == 'Semua Tipe' ? 'selected' : '' }}>Semua Tipe</option>
                        @foreach($logNames as $name)
                            <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>{{ strtoupper($name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold small text-muted text-uppercase">User</label>
                    <select class="form-select border-1 shadow-sm" name="user_id">
                        <option value="Semua User" {{ request('user_id') == 'Semua User' ? 'selected' : '' }}>Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold small text-muted text-uppercase">Dari Tanggal</label>
                    <input type="date" class="form-control border-1 shadow-sm" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold small text-muted text-uppercase">Sampai Tanggal</label>
                    <input type="date" class="form-control border-1 shadow-sm" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-lg-2 col-md-12 d-flex align-items-end">
                    <div class="btn-group w-100 shadow-sm">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="{{ route('superadmin.audit') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 shadow-sm">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 shadow-sm ps-0" name="search" placeholder="Cari aktivitas atau keterangan..." value="{{ request('search') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="py-3 ps-4" style="width: 150px;">Waktu</th>
                            <th class="py-3">User</th>
                            <th class="py-3">Aktivitas & Subjek</th>
                            <th class="py-3">Tipe</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-medium text-dark">{{ $activity->created_at->format('d/m/Y') }}</span>
                                    <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle text-center me-2" style="width: 32px; height: 32px; line-height: 32px;">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $activity->causer->name ?? 'System' }}</span>
                                        <small class="text-muted">{{ $activity->causer->role ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium">{{ $activity->description }}</span>
                                    @if($activity->subject_type)
                                        <div class="mt-1">
                                            <span class="badge bg-light text-dark border fw-normal py-1">
                                                <i class="fas fa-cube text-muted me-1"></i>
                                                {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $color = 'primary';
                                    $desc = strtolower($activity->description);
                                    if (Str::contains($desc, ['login', 'logout'])) $color = 'info';
                                    elseif (Str::contains($desc, ['create', 'store', 'add', 'submit'])) $color = 'success';
                                    elseif (Str::contains($desc, ['update', 'edit', 'change', 'toggle', 'approve', 'reject'])) $color = 'warning';
                                    elseif (Str::contains($desc, ['delete', 'remove', 'destroy'])) $color = 'danger';
                                @endphp
                                <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} border border-{{ $color }} border-opacity-25 px-2 py-1 rounded">
                                    {{ strtoupper($activity->log_name ?? 'DEFAULT') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-outline-primary btn-sm rounded-3 border-0" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#activity-detail-{{ $activity->id }}">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse" id="activity-detail-{{ $activity->id }}">
                             <td colspan="5" class="bg-light p-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3 small text-uppercase">Informasi Perubahan</h6>
                                        @if($activity->properties && count($activity->properties) > 0)
                                            <pre class="bg-white border p-3 rounded-3 small mb-0 overflow-auto" style="max-height: 300px;">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        @else
                                            <p class="text-muted small mb-0">Tidak ada detail data yang dicatat.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <h6 class="fw-bold mb-3 small text-uppercase">Detail Subjek</h6>
                                        <ul class="list-group list-group-flush bg-transparent">
                                            <li class="list-group-item bg-transparent px-0 border-0 py-1">
                                                <span class="text-muted small">ID Subjek:</span>
                                                <span class="fw-medium small ms-1">#{{ $activity->subject_id }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent px-0 border-0 py-1">
                                                <span class="text-muted small">Tipe Model:</span>
                                                <span class="fw-medium small ms-1">{{ $activity->subject_type }}</span>
                                            </li>
                                            <li class="list-group-item bg-transparent px-0 border-0 py-1">
                                                <span class="text-muted small">Causer IP:</span>
                                                <span class="fw-medium small ms-1">{{ $activity->properties['ip'] ?? '-' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                             </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-5">
                                    <i class="fas fa-clipboard-question fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Tidak ada aktivitas ditemukan sesuai kriteria filter Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($activities->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $activities->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .audit-wrapper .card { transition: all 0.3s ease; }
    .audit-wrapper select, .audit-wrapper input { font-size: 0.9rem; }
    .audit-wrapper .table thead th {
        font-weight: 600;
        letter-spacing: 0.5px;
        border-top: none;
    }
    .audit-wrapper .avatar-sm { font-size: 1.1rem; }
    .audit-wrapper .badge { font-size: 0.75rem; }
    
    .collapse td { border-top: none; }
    
    pre::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    pre::-webkit-scrollbar-thumb {
        background-color: #dee2e6;
        border-radius: 4px;
    }
</style>
@endsection
