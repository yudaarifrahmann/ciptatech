@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="report-wrapper py-3">
    <div class="report-header mb-5">
        <div class="d-flex align-items-center mb-3">
            <div class="header-icon me-3">
                <div class="icon-wrapper bg-warning bg-opacity-10 p-3 rounded-circle">
                    <i class="fas fa-edit fa-2x text-warning"></i>
                </div>
            </div>
            <div>
                <h4 class="fw-bold mb-1">Edit Laporan</h4>
                <p class="text-muted mb-0">Perbarui data laporan tugas Anda</p>
            </div>
        </div>
        
        @if($report->status == 'revisi')
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-lg me-3"></i>
            <div>
                <strong>Catatan Revisi dari Supervisor:</strong><br>
                {{ $report->feedback ?? 'Mohon perbaiki laporan ini sesuai instruksi.' }}
            </div>
        </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-form me-2"></i>Form Edit Laporan
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('pic.report.update', $report->id) }}" enctype="multipart/form-data" id="reportForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-tasks me-1 text-primary"></i>
                                Nama Tugas
                            </label>
                            <input type="text" 
                                   name="task_name" 
                                   class="form-control form-control-lg border-1 shadow-sm" 
                                   value="{{ old('task_name', $report->task_name) }}"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-align-left me-1 text-primary"></i>
                                Deskripsi Progress
                            </label>
                            <textarea name="description" 
                                      class="form-control border-1 shadow-sm" 
                                      rows="5" 
                                      required>{{ old('description', $report->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-chart-line me-1 text-primary"></i>
                                Persentase Progress
                            </label>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <input type="range" 
                                           class="form-range" 
                                           min="0" 
                                           max="100" 
                                           step="5" 
                                           id="progressRange"
                                           value="{{ old('progress', $report->progress) }}"
                                           oninput="updateProgressValue(this.value)">
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" 
                                               name="progress" 
                                               class="form-control form-control-lg text-center fw-bold border-primary" 
                                               id="progressInput"
                                               value="{{ old('progress', $report->progress) }}"
                                               min="0" 
                                               max="100" 
                                               oninput="updateProgressRange(this.value)">
                                        <span class="input-group-text bg-primary text-white">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" 
                                         id="progressBar" 
                                         role="progressbar" 
                                         style="width: {{ $report->progress }}%" 
                                         aria-valuenow="{{ $report->progress }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->division_id == 3)
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fab fa-github me-1 text-dark"></i>
                                Link Repository GitHub
                            </label>
                            <input type="url" 
                                   name="github_link" 
                                   class="form-control form-control-lg border-1 shadow-sm" 
                                   value="{{ old('github_link', $report->github_link) }}"
                                   placeholder="https://github.com/username/repository">
                        </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-paperclip me-1 text-primary"></i>
                                Update File @if($report->file_path) <small class="text-muted">(Biarkan kosong jika tidak ingin ganti)</small> @endif
                            </label>
                            @if($report->file_path)
                            <div class="mb-2 small">
                                <i class="fas fa-file-alt me-1"></i> File saat ini: 
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank">Lihat File</a>
                            </div>
                            @endif
                            <input type="file" name="file" class="form-control" id="fileInput">
                        </div>

                        @if(auth()->user()->division_id == 1)
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-video me-1 text-success"></i>
                                Update Video @if($report->video) <small class="text-muted">(Biarkan kosong jika tidak ingin ganti)</small> @endif
                            </label>
                            @if($report->video)
                            <div class="mb-2 small">
                                <i class="fas fa-video me-1"></i> Video saat ini: 
                                <a href="{{ asset('storage/' . $report->video) }}" target="_blank">Lihat Video</a>
                            </div>
                            @endif
                            <input type="file" name="video" class="form-control" id="videoInput" accept="video/*">
                        </div>
                        @endif

                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <a href="{{ route('pic.report.history') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateProgressValue(value) {
        document.getElementById('progressInput').value = value;
        const progressBar = document.getElementById('progressBar');
        progressBar.style.width = value + '%';
        progressBar.setAttribute('aria-valuenow', value);
        
        if (value < 30) progressBar.className = 'progress-bar bg-danger';
        else if (value < 70) progressBar.className = 'progress-bar bg-warning';
        else if (value < 100) progressBar.className = 'progress-bar bg-info';
        else progressBar.className = 'progress-bar bg-success';
    }
    
    function updateProgressRange(value) {
        if (value > 100) value = 100;
        if (value < 0) value = 0;
        document.getElementById('progressRange').value = value;
        updateProgressValue(value);
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateProgressValue({{ $report->progress }});
        
        const form = document.getElementById('reportForm');
        const submitBtn = document.getElementById('submitBtn');
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        });
    });
</script>
@endsection
