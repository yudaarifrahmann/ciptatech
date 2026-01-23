@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('supervisor.tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('supervisor.tasks.edit', $task) }}" class="btn btn-primary btn-sm px-3">
                <i class="fas fa-edit me-1"></i>Edit Group
            </a>
            <form action="{{ route('supervisor.tasks.destroy', $task) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('Menghapus group ini akan menghapus semua item tugas di dalamnya. Lanjutkan?')">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="fw-bold mb-1 text-primary">{{ $task->title }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-building me-1"></i> Divisi: <strong>{{ $task->division->name }}</strong>
                            </p>
                        </div>
                        <span class="badge rounded-pill bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'submitted' ? 'warning' : 'info') }} px-3 py-2">
                            {{ ucfirst($task->status) }}
                        </span>
                    </div>
                    
                    <div class="row pt-3 border-top">
                        <div class="col-md-6">
                            <h6 class="text-muted small text-uppercase fw-bold">Deadline Tunggal</h6>
                            <p class="mb-0 fw-bold text-danger">
                                <i class="fas fa-calendar-check me-2"></i>
                                {{ $task->deadline ? $task->deadline->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-muted small text-uppercase fw-bold">Dibuat Pada</h6>
                            <p class="mb-0 text-muted">
                                {{ $task->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3"><i class="fas fa-list-check me-2 text-primary"></i>Item Tugas Dalam Group</h5>
            @php
                // Ambil item tugas yang memiliki parent id ini
                $taskItems = \App\Models\Task::where('task_group_id', $task->id)->orderBy('task_order', 'asc')->get();
            @endphp

            @foreach($taskItems as $item)
                <div class="card shadow-sm border-0 mb-3 border-start border-4 border-primary">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ $item->task_item_title }}</h6>
                                @if($item->description)
                                    <p class="text-muted small mb-0">{{ $item->description }}</p>
                                @else
                                    <p class="text-muted small mb-0"><em>Tidak ada deskripsi tambahan.</em></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase small fw-bold opacity-75">Status Keseluruhan</h6>
                    <h2 class="fw-bold mb-3">{{ number_format($task->submissions->where('status', 'approved')->count() / max($task->submissions->count(), 1) * 100, 0) }}%</h2>
                    
                    @php
                        $submissions = $task->submissions;
                        $total = $submissions->count();
                        $approved = $submissions->where('status', 'approved')->count();
                        $submitted = $submissions->where('status', 'submitted')->count();
                    @endphp

                    <div class="progress mb-3" style="height: 10px; background: rgba(255,255,255,0.2);">
                        <div class="progress-bar bg-white" style="width: {{ $total > 0 ? ($approved / $total) * 100 : 0 }}%"></div>
                    </div>
                    
                    <p class="small mb-0">{{ $approved }} dari {{ $total }} PIC telah diselesaikan</p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="fas fa-list me-2"></i>Detail Submission - Task Submissions</h6>
                </div>
                <div class="card-body p-0">
                    @if ($task->submissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="px-3 py-2 small fw-bold">PIC</th>
                                        <th class="px-3 py-2 small fw-bold">Status</th>
                                        <th class="px-3 py-2 small fw-bold">Tugas Selesai</th>
                                        <th class="px-3 py-2 small fw-bold">Disubmit</th>
                                        <th class="px-3 py-2 small fw-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($task->submissions as $submission)
                                        <tr class="align-middle">
                                            <td class="px-3 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-2 bg-light text-primary fw-bold">
                                                        {{ strtoupper(substr($submission->pic->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong class="d-block small">{{ $submission->pic->name }}</strong>
                                                        <small class="text-muted">{{ $submission->pic->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3">
                                                <span class="badge bg-{{ $submission->status == 'approved' ? 'success' : ($submission->status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($submission->status) }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3">
                                                <small class="text-muted">
                                                    <strong>{{ $submission->completed_tasks_count ?? 0 }}</strong> / {{ $taskItems->count() }}
                                                </small>
                                            </td>
                                            <td class="px-3 py-3">
                                                <small class="text-muted">
                                                    @if ($submission->submitted_at)
                                                        {{ $submission->submitted_at->format('d M Y H:i') }}
                                                    @else
                                                        <span class="badge bg-secondary">Belum</span>
                                                    @endif
                                                </small>
                                            </td>
                                            <td class="px-3 py-3">
                                                <a href="{{ route('supervisor.tasks.review', $task) }}" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center p-4 text-muted">Belum ada submission dari PIC</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Additional Submission Details -->
                        <div class="border-top p-3 bg-light">
                            <h6 class="fw-bold mb-3 small"><i class="fas fa-info-circle me-2"></i>Informasi Submission Lengkap</h6>
                            @foreach ($task->submissions as $submission)
                                <div class="mb-3 p-3 border rounded bg-white">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong class="text-primary">{{ $submission->pic->name }}</strong>
                                        <span class="badge bg-{{ $submission->status == 'approved' ? 'success' : ($submission->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="row g-2 small text-muted mb-2">
                                        <div class="col-6">
                                            <i class="fas fa-file-alt me-1"></i>
                                            <strong>Catatan:</strong> {{ $submission->submission_notes ?? '-' }}
                                        </div>
                                        <div class="col-6">
                                            <i class="fas fa-check-circle me-1"></i>
                                            <strong>Tugas Selesai:</strong> {{ $submission->completed_tasks_count ?? 0 }}/{{ $taskItems->count() }}
                                        </div>
                                    </div>

                                    <div class="row g-2 small text-muted">
                                        <div class="col-6">
                                            <i class="fas fa-calendar me-1"></i>
                                            <strong>Disubmit:</strong> {{ $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : 'Belum' }}
                                        </div>
                                        <div class="col-6">
                                            <i class="fas fa-clock me-1"></i>
                                            <strong>Direview:</strong> {{ $submission->reviewed_at ? $submission->reviewed_at->format('d M Y H:i') : 'Belum' }}
                                        </div>
                                    </div>

                                    @if ($submission->reviewer_feedback)
                                        <div class="alert alert-info mt-2 mb-0 small">
                                            <strong>Feedback Reviewer:</strong><br>
                                            {{ $submission->reviewer_feedback }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            <small>Belum ada submission dari PIC</small>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 p-3 text-center">
                    <a href="{{ route('supervisor.tasks.review', $task) }}" class="btn btn-primary btn-sm w-100 fw-bold">
                        REVIEW SEMUA SUBMISSION
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }
    .card { border-radius: 12px; }
</style>
@endsection