@extends('layouts.app')

@section('title', 'Review Submission - ' . $task->title)

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('supervisor.tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Task Info -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">{{ $task->title }}</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Divisi</small>
                        <strong>{{ $task->division->name }}</strong>
                    </div>

                    @if ($task->deadline)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Deadline</small>
                            <strong>{{ $task->deadline->format('d M Y') }}</strong>
                        </div>
                    @endif

                    <div>
                        <small class="text-muted d-block mb-1">Status</small>
                        <span class="badge bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'submitted' ? 'warning' : 'info') }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-inbox me-2"></i>
                        Submission dari PIC ({{ $submissions->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @forelse($submissions as $submission)
                        <div class="submission-item mb-4 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">
                                        <i class="fas fa-user-circle me-2"></i>
                                        {{ $submission->pic->name }}
                                    </h6>
                                    <small class="text-muted">{{ $submission->pic->email }}</small>
                                </div>
                                <span class="badge bg-{{ $submission->status == 'approved' ? 'success' : ($submission->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>

                            <!-- Submission Notes -->
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Catatan Submission:</small>
                                <p class="mb-0">{{ $submission->submission_notes }}</p>
                            </div>

                            <!-- Submission File -->
                            @if ($submission->submission_file)
                                <div class="mb-3">
                                    <a href="{{ asset('storage/' . $submission->submission_file) }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>
                                        Download File
                                    </a>
                                </div>
                            @endif

                            <!-- Reviewer Feedback -->
                            @if ($submission->reviewer_feedback)
                                <div class="alert alert-info mb-3 border-0">
                                    <strong>Feedback dari Reviewer:</strong>
                                    <p class="mb-0 mt-2">{{ $submission->reviewer_feedback }}</p>
                                </div>
                            @endif

                            <!-- Dates -->
                            <div class="text-muted small mb-3">
                                <i class="fas fa-clock me-1"></i>
                                Disubmit: {{ $submission->submitted_at->format('d M Y H:i') }}
                                @if ($submission->reviewed_at)
                                    | Ditinjau: {{ $submission->reviewed_at->format('d M Y H:i') }}
                                @endif
                            </div>

                            <!-- Actions -->
                            @if ($submission->status === 'submitted')
                                <div class="d-flex gap-2">
                                    <form action="{{ route('supervisor.submissions.approve', $submission) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check me-1"></i>Setujui
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $submission->id }}">
                                        <i class="fas fa-times me-1"></i>Tolak
                                    </button>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $submission->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tolak Submission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('supervisor.submissions.reject', $submission) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <label for="feedback{{ $submission->id }}" class="form-label fw-bold">
                                                            Feedback untuk PIC
                                                        </label>
                                                        <textarea class="form-control" id="feedback{{ $submission->id }}" 
                                                                  name="reviewer_feedback" rows="4" 
                                                                  placeholder="Jelaskan apa yang perlu diperbaiki" required></textarea>
                                                        <small class="text-muted">PIC akan diminta memperbaiki dan mengirim ulang</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-paper-plane me-1"></i>Kirim Feedback
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($submission->status === 'approved')
                                <div class="alert alert-success border-0 mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Submission ini telah disetujui. Tugas selesai!
                                </div>
                            @elseif ($submission->status === 'rejected')
                                <div class="alert alert-warning border-0 mb-0">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    Submission ini telah ditolak. Menunggu perbaikan dari PIC...
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            <p class="mb-0">Belum ada submission</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .submission-item {
        background: #f8f9fa;
        transition: all 0.2s ease;
    }

    .submission-item:hover {
        background: #e9ecef;
    }
</style>
@endsection
