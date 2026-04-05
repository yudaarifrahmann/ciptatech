@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="report-wrapper py-3">
    <div class="report-header mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <div class="header-icon me-3">
                    <div class="icon-wrapper bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-file-invoice fa-2x text-primary"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Detail Laporan</h4>
                    <p class="text-muted mb-0">Informasi lengkap mengenai laporan tugas</p>
                </div>
            </div>
            <a href="{{ route('pic.report.history') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Informasi Tugas</h5>
                    @php
                        $statusMap = [
                            'draft' => ['secondary', 'Draft'],
                            'progress' => ['info', 'Progress'],
                            'menunggu review' => ['warning', 'Menunggu Review'],
                            'revisi' => ['danger', 'Perbaikan'],
                            'perbaikan' => ['danger', 'Perbaikan'],
                            'selesai' => ['success', 'Selesai'],
                        ];
                        [$color, $label] = $statusMap[$report->status] ?? ['secondary', $report->status];
                    @endphp
                    <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3 py-2 rounded-pill border border-{{ $color }} border-opacity-25">
                        {{ $label }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Nama Tugas</label>
                        <h4 class="fw-bold text-dark">{{ $report->task_name }}</h4>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Deskripsi Progress</label>
                        <div class="text-dark bg-light p-3 rounded-3" style="white-space: pre-line;">
                            {{ $report->description }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Tanggal Kirim</label>
                            <p class="fw-bold mb-0">{{ $report->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Update Terakhir</label>
                            <p class="fw-bold mb-0">{{ $report->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Progress Capaian</label>
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-3" style="height: 12px; border-radius: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $report->progress }}%" aria-valuenow="{{ $report->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="fw-bold mb-0 text-success">{{ $report->progress }}%</h4>
                        </div>
                    </div>
                </div>
            </div>

            @if($report->feedback)
            <div class="card border-0 shadow-sm mb-4 border-start border-4 border-danger">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-danger mb-3">
                        <i class="fas fa-comment-dots me-2"></i>Feedback dari Supervisor
                    </h6>
                    <p class="mb-0 text-dark">{{ $report->feedback }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Lampiran & Link</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">File Dokumen</label>
                        @if($report->file_path)
                            <div class="d-grid">
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-file-download me-2"></i>Download File
                                </a>
                            </div>
                        @else
                            <p class="text-muted fst-italic small">Tidak ada lampiran file</p>
                        @endif
                    </div>

                    @if(auth()->user()->division_id == 3)
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Link GitHub</label>
                        @if($report->github_link)
                            <a href="{{ $report->github_link }}" target="_blank" class="text-decoration-none d-flex align-items-center p-2 rounded bg-dark bg-opacity-10 text-dark">
                                <i class="fab fa-github fa-lg me-3"></i>
                                <span class="text-truncate" style="max-width: 200px;">{{ $report->github_link }}</span>
                                <i class="fas fa-external-link-alt ms-auto small"></i>
                            </a>
                        @else
                            <p class="text-muted fst-italic small">Tidak ada link GitHub</p>
                        @endif
                    </div>
                    @endif

                    @if(auth()->user()->division_id == 1)
                    <div class="mb-0">
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Lampiran Video</label>
                        @if($report->video)
                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm">
                                <video controls>
                                    <source src="{{ asset('storage/' . $report->video) }}" type="video/mp4">
                                    Browser Anda tidak mendukung preview video.
                                </video>
                            </div>
                        @else
                            <p class="text-muted fst-italic small">Tidak ada lampiran video</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            @if($report->status !== 'selesai' && $report->status !== 'menunggu review')
            <div class="d-grid mt-4">
                <a href="{{ route('pic.report.edit', $report->id) }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-edit me-2"></i>Gunakan / Edit Kembali
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
