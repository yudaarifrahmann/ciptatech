@extends('layouts.app')

@section('title', 'Lapor Tugas')

@section('content')
<div class="report-wrapper py-3">
    <!-- Header Section -->
    <div class="report-header mb-5">
        <div class="d-flex align-items-center mb-3">
            <div class="header-icon me-3">
                <div class="icon-wrapper bg-primary bg-opacity-10 p-3 rounded-circle">
                    <i class="fas fa-file-circle-plus fa-2x text-primary"></i>
                </div>
            </div>
            <div>
                <h4 class="fw-bold mb-1">Lapor Tugas</h4>
                <p class="text-muted mb-0">Kirim laporan progress tugas Anda</p>
            </div>
        </div>
        
        <div class="progress-steps mb-4">
            <div class="d-flex align-items-center">
                <div class="step active">
                    <div class="step-circle">1</div>
                    <div class="step-label">Form Laporan</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">2</div>
                    <div class="step-label">Review</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-edit me-2"></i>Form Laporan Tugas
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="/pic/report" enctype="multipart/form-data" id="reportForm">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-tasks me-1 text-primary"></i>
                                Nama Tugas
                            </label>
                            <input type="text" 
                                   name="task_name" 
                                   class="form-control form-control-lg border-1 shadow-sm" 
                                   placeholder="Masukkan nama tugas Anda"
                                   required
                                   autofocus>
                            <div class="form-text text-muted mt-1">
                                Contoh: "Implementasi Login" atau "Update Dashboard"
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-align-left me-1 text-primary"></i>
                                Deskripsi Progress
                            </label>
                            <textarea name="description" 
                                      class="form-control border-1 shadow-sm" 
                                      rows="5" 
                                      placeholder="Jelaskan detail progress yang telah Anda capai..."
                                      style="resize: vertical;"></textarea>
                            <div class="form-text text-muted mt-1">
                                Jelaskan pencapaian, kendala, dan rencana selanjutnya
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">
                                <i class="fas fa-chart-line me-1 text-primary"></i>
                                Persentase Progress
                            </label>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <input type="range" 
                                           name="progress" 
                                           class="form-range" 
                                           min="0" 
                                           max="100" 
                                           step="5" 
                                           id="progressRange"
                                           oninput="updateProgressValue(this.value)">
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" 
                                               name="progress" 
                                               class="form-control form-control-lg text-center fw-bold border-primary" 
                                               id="progressInput"
                                               min="0" 
                                               max="100" 
                                               placeholder="0-100"
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
                                         style="width: 0%" 
                                         aria-valuenow="0" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">0% - Belum dimulai</small>
                                    <small class="text-muted">100% - Selesai</small>
                                </div>
                            </div>
                        </div>

                        <!-- DYNAMIC FIELDS FROM SUPERVISOR SCHEMA -->
                        @if($schema && is_array($schema->schema))
                            <div class="dynamic-fields-section mb-4 mt-5 pt-4 border-top">
                                <h6 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-list-ul me-2"></i>Informasi Tambahan dari Divisi
                                </h6>
                                
                                @foreach($schema->schema as $index => $field)
                                    <div class="mb-4">
                                        <label class="form-label fw-bold mb-2">
                                            {{ $field['label'] }}
                                            @if(isset($field['required']) && $field['required'])
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        @if($field['type'] == 'text')
                                            <input type="text" name="additional_data[{{ $field['label'] }}]" class="form-control" placeholder="Masukkan {{ $field['label'] }}" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                                        @elseif($field['type'] == 'textarea')
                                            <textarea name="additional_data[{{ $field['label'] }}]" class="form-control" rows="3" placeholder="Masukkan {{ $field['label'] }}" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}></textarea>
                                        @elseif($field['type'] == 'number')
                                            <input type="number" name="additional_data[{{ $field['label'] }}]" class="form-control" placeholder="0" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                                        @elseif($field['type'] == 'date')
                                            <input type="date" name="additional_data[{{ $field['label'] }}]" class="form-control" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                                        @elseif($field['type'] == 'file')
                                            <input type="file" name="additional_files[{{ $field['label'] }}]" class="form-control" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                                        @elseif($field['type'] == 'select')
                                            <select name="additional_data[{{ $field['label'] }}]" class="form-select" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                                                <option value="">Pilih {{ $field['label'] }}</option>
                                                <!-- Options could be expanded here if supervisor UI allows it -->
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif


                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <a href="/pic/dashboard" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>
                                <span>Submit Laporan</span>
                                <span class="spinner-border spinner-border-sm ms-2" id="submitSpinner" style="display: none;"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            <div class="card border-0 bg-light">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-lightbulb text-warning me-2 mt-1"></i>
                        <div>
                            <small class="fw-bold">Tips:</small>
                            <small class="text-muted">
                                Pastikan deskripsi progress jelas dan detail. Upload file pendukung jika diperlukan.
                                Progress 100% akan otomatis mengubah status tugas menjadi "Menunggu Review".
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .report-wrapper {
        padding: 1rem 0;
    }
    
    .report-header {
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
    
    .progress-steps {
        max-width: 600px;
    }
    
    .step {
        text-align: center;
        flex: 1;
    }
    
    .step-circle {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: bold;
        color: #6c757d;
        border: 3px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .step.active .step-circle {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    .step-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .step.active .step-label {
        color: #0d6efd;
        font-weight: 600;
    }
    
    .step-line {
        height: 3px;
        background: #e9ecef;
        flex: 1;
        margin: 0 10px;
        position: relative;
        top: -20px;
    }
    
    .step.active ~ .step-line {
        background: #e9ecef;
    }
    
    .card {
        border-radius: 12px;
    }
    
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        border-radius: 8px;
    }
    
    .form-control:focus, .form-range:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #86b7fe;
    }
    
    .file-upload-area {
        background: rgba(13, 110, 253, 0.02);
        border-color: #dee2e6 !important;
        transition: all 0.3s ease;
    }
    
    .file-upload-area:hover {
        background: rgba(13, 110, 253, 0.05);
        border-color: #86b7fe !important;
    }
    
    .border-dashed {
        border-style: dashed !important;
    }
    
    .form-range::-webkit-slider-thumb {
        background: #0d6efd;
        width: 24px;
        height: 24px;
    }
    
    .form-range::-moz-range-thumb {
        background: #0d6efd;
        width: 24px;
        height: 24px;
    }
    
    #submitBtn {
        min-width: 180px;
        border-radius: 8px;
    }
    
    /* Video Upload Styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        font-weight: 500;
    }
    
    .alert-success {
        background-color: #d1e7dd;
        border-color: #badbcc;
        color: #0f5132;
    }
    
    @media (max-width: 768px) {
        .report-header {
            padding: 1.5rem;
        }
        
        .icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .icon-wrapper i {
            font-size: 1.5rem;
        }
        
        .step-circle {
            width: 32px;
            height: 32px;
            font-size: 0.875rem;
        }
        
        .step-line {
            top: -16px;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .form-control-lg {
            font-size: 1rem;
            padding: 0.625rem 0.875rem;
        }
        
        #submitBtn {
            width: 100%;
            margin-top: 1rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
        }
    }
    
    @media (max-width: 576px) {
        .report-wrapper {
            padding: 0.5rem;
        }
        
        .report-header {
            padding: 1.25rem;
            margin-bottom: 2rem;
        }
        
        .file-upload-area {
            padding: 1.5rem 1rem !important;
        }
        
        .upload-icon i {
            font-size: 2.5rem !important;
        }
    }
</style>

<script>
    function updateProgressValue(value) {
        document.getElementById('progressInput').value = value;
        document.getElementById('progressBar').style.width = value + '%';
        document.getElementById('progressBar').setAttribute('aria-valuenow', value);
        
        // Update progress bar color based on value
        const progressBar = document.getElementById('progressBar');
        if (value < 30) {
            progressBar.className = 'progress-bar bg-danger';
        } else if (value < 70) {
            progressBar.className = 'progress-bar bg-warning';
        } else if (value < 100) {
            progressBar.className = 'progress-bar bg-info';
        } else {
            progressBar.className = 'progress-bar bg-success';
        }
    }
    
    function updateProgressRange(value) {
        if (value > 100) value = 100;
        if (value < 0) value = 0;
        document.getElementById('progressRange').value = value;
        updateProgressValue(value);
    }
    
    document.getElementById('fileInput').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            document.getElementById('fileName').textContent = fileName;
            document.getElementById('filePreview').style.display = 'block';
        }
    });
    
    function clearFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').style.display = 'none';
    }
    
    // Video upload handler (untuk Multimedia)
    const videoInput = document.getElementById('videoInput');
    if (videoInput) {
        videoInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                
                // Validasi tipe file video
                const validVideoTypes = [
                    'video/mp4',
                    'video/mpeg',
                    'video/quicktime',
                    'video/x-msvideo',
                    'video/x-matroska'
                ];
                
                if (!validVideoTypes.includes(file.type)) {
                    alert('Hanya file video (MP4, MOV, AVI, MKV) yang diizinkan!');
                    this.value = '';
                    document.getElementById('videoPreview').style.display = 'none';
                    return;
                }
                
                // Tampilkan info video
                document.getElementById('videoFileName').textContent = file.name;
                document.getElementById('videoFileSize').textContent = formatFileSize(file.size);
                document.getElementById('videoPreview').style.display = 'block';
            }
        });
    }
    
    function clearVideo() {
        document.getElementById('videoInput').value = '';
        document.getElementById('videoPreview').style.display = 'none';
    }
    
    // Function untuk format ukuran file
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
    
    // Initialize progress bar on load
    document.addEventListener('DOMContentLoaded', function() {
        updateProgressValue(0);
        
        // Form submission handler
        const form = document.getElementById('reportForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');
        const submitText = submitBtn.querySelector('span:first-of-type');
        
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitText.textContent = 'Mengirim...';
            submitSpinner.style.display = 'inline-block';
        });
    });
</script>
@endsection