@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('supervisor.tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Task Details -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">{{ $task->title }}</h5>
                        <span class="badge bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'submitted' ? 'warning' : 'info') }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Divisi</h6>
                            <p class="mb-0">
                                <i class="fas fa-building me-2 text-primary"></i>
                                <strong>{{ $task->division->name }}</strong>
                            </p>
                        </div>
                        @if ($task->deadline)
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Deadline</h6>
                                <p class="mb-0">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    <strong>{{ $task->deadline->format('d M Y') }}</strong>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Deskripsi Tugas</h6>
                        <div class="border-start border-primary ps-3">
                            {{ $task->description }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Dibuat</h6>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $task->created_at->format('d M Y H:i') }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-light border-top py-3">
                    <div class="d-flex gap-2">
                        <a href="{{ route('supervisor.tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('supervisor.tasks.review', $task) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check me-1"></i>Review Submission
                        </a>
                        <form action="{{ route('supervisor.tasks.destroy', $task) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-lg-4">
            <!-- Submission Progress -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Progress Submission
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $submissions = $task->submissions;
                        $approved = $submissions->where('status', 'approved')->count();
                        $rejected = $submissions->where('status', 'rejected')->count();
                        $submitted = $submissions->where('status', 'submitted')->count();
                        $total = $submissions->count();
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total PIC</span>
                            <strong>{{ $total }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-success">Disetujui</span>
                            <strong>{{ $approved }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-warning">Menunggu Review</span>
                            <strong>{{ $submitted }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-danger">Revisi Diperlukan</span>
                            <strong>{{ $rejected }}</strong>
                        </div>
                    </div>

                    <div class="progress mb-3" style="height: 30px;">
                        @if ($approved > 0)
                            <div class="progress-bar bg-success" style="width: {{ ($approved / $total) * 100 }}%">
                                {{ $approved }}
                            </div>
                        @endif
                        @if ($submitted > 0)
                            <div class="progress-bar bg-warning" style="width: {{ ($submitted / $total) * 100 }}%">
                                {{ $submitted }}
                            </div>
                        @endif
                        @if ($rejected > 0)
                            <div class="progress-bar bg-danger" style="width: {{ ($rejected / $total) * 100 }}%">
                                {{ $rejected }}
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('supervisor.tasks.review', $task) }}" class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-list me-1"></i>Lihat Semua Submission
                    </a>
                </div>
            </div>

            <!-- PIC List -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-users me-2"></i>
                        PIC ({{ $total }})
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach ($task->submissions as $submission)
                            <div class="list-group-item px-3 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <strong class="d-block">{{ $submission->pic->name }}</strong>
                                        <small class="text-muted">{{ $submission->pic->email }}</small>
                                    </div>
                                    <span class="badge bg-{{ $submission->status == 'approved' ? 'success' : ($submission->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
