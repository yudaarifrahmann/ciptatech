@extends('layouts.app')

@section('title', 'Kerjakan Tugas - ' . $task->title)

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('pic.tasks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Task Details -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Detail Tugas
                    </h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">{{ $task->title }}</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Dari Supervisor</small>
                        <strong>{{ $task->supervisor->name }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Deskripsi</small>
                        <p class="mb-0 text-break">{{ $task->description }}</p>
                    </div>

                    @if ($task->deadline)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Deadline</small>
                            <strong>{{ $task->deadline->format('d M Y') }}</strong>
                            @if (\Carbon\Carbon::now()->isAfter($task->deadline))
                                <span class="badge bg-danger ms-2">Terlewat</span>
                            @else
                                <br>
                                <small class="text-muted">
                                    Sisa: <strong>{{ $task->deadline->diffInDays(\Carbon\Carbon::now()) }} hari</strong>
                                </small>
                            @endif
                        </div>
                    @endif

                    <!-- Status -->
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Status</small>
                        @if ($mySubmission->status === 'approved')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Selesai/Disetujui
                            </span>
                        @elseif ($mySubmission->status === 'rejected')
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle me-1"></i>Perlu Revisi
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-hourglass-end me-1"></i>Menunggu Review
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission Form -->
        <div class="col-lg-8">
            @if ($mySubmission->status === 'approved')
                <div class="card shadow-sm border-0 bg-success bg-opacity-10">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                        <h5 class="fw-bold mb-2">Tugas Selesai!</h5>
                        <p class="text-muted mb-0">Submission Anda telah disetujui oleh supervisor. Tugas tidak bisa diubah lagi.</p>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light border-bottom py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-upload me-2"></i>
                            Kirim Pekerjaan
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($mySubmission->status === 'rejected')
                            <div class="alert alert-danger border-0 mb-4" role="alert">
                                <strong class="d-block mb-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Feedback Supervisor:
                                </strong>
                                <p class="mb-0">{{ $mySubmission->reviewer_feedback }}</p>
                            </div>
                        @endif

                        <form action="{{ route('pic.tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Submission Notes -->
                            <div class="mb-4">
                                <label for="submission_notes" class="form-label fw-bold">
                                    <i class="fas fa-sticky-note me-2"></i>Catatan Submission
                                </label>
                                <textarea class="form-control @error('submission_notes') is-invalid @enderror" 
                                          id="submission_notes" name="submission_notes" rows="5"
                                          placeholder="Jelaskan apa yang telah Anda lakukan, hasil pekerjaan, dan informasi penting lainnya"
                                          required>{{ $mySubmission->submission_notes }}</textarea>
                                @error('submission_notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 10 karakter. Jelaskan dengan detail hasil pekerjaan Anda.</small>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-4">
                                <label for="submission_file" class="form-label fw-bold">
                                    <i class="fas fa-file-upload me-2"></i>Upload File (Opsional)
                                </label>
                                <div class="mb-2">
                                    <input type="file" class="form-control @error('submission_file') is-invalid @enderror" 
                                           id="submission_file" name="submission_file">
                                    @error('submission_file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    Format: PDF, DOC, DOCX, XLS, XLSX, IMG, ZIP. Max 10MB
                                    @if ($mySubmission->submission_file)
                                        <br>
                                        <strong>File sebelumnya:</strong> 
                                        <a href="{{ asset('storage/' . $mySubmission->submission_file) }}" target="_blank" class="text-primary">
                                            Download
                                        </a>
                                    @endif
                                </small>
                            </div>

                            <!-- Info -->
                            <div class="alert alert-info border-0" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Catatan:</strong> Submission Anda akan dikirim ke supervisor untuk ditinjau. 
                                Anda dapat mengubah submission sampai supervisor memberikan approval.
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pekerjaan
                                </button>
                                <a href="{{ route('pic.tasks.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Previous Submissions -->
                @if ($mySubmission->submitted_at)
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-light border-bottom py-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-history me-2"></i>
                                Riwayat Submission
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker">
                                        <i class="fas fa-{{ $mySubmission->status === 'approved' ? 'check-circle text-success' : 'hourglass-end text-warning' }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $mySubmission->submitted_at->format('d M Y H:i') }}
                                        </small>
                                        <p class="mb-0 mt-1">{{ Str::limit($mySubmission->submission_notes, 100) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        left: -25px;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 50%;
        font-size: 0.75rem;
    }
</style>
@endsection
