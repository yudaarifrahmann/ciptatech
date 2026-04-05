@extends('layouts.app')

@section('title', 'Daily Report')

@section('content')
<div class="container">
    <h4 class="mb-4">Daily Report</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pic.daily-report.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- TANGGAL (TIDAK BISA DIPILIH - OTOMATIS HARI INI) -->
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fas fa-calendar-day me-1 text-primary"></i>
                Tanggal
            </label>
            <div class="input-group">
                <input type="text" class="form-control bg-light" 
                       value="{{ now()->translatedFormat('d F Y') }}" 
                       readonly disabled>
                <span class="input-group-text bg-light">
                    <i class="fas fa-calendar-check text-primary"></i>
                </span>
            </div>
            <!-- Input hidden untuk mengirim tanggal ke server -->
            <input type="hidden" name="report_date" value="{{ now()->toDateString() }}">
            <div class="form-text text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Laporan harian untuk tanggal hari ini (otomatis)
            </div>
        </div>

        <!-- NAMA (OTOMATIS DARI USER LOGIN) -->
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fas fa-user me-1 text-primary"></i>
                Nama
            </label>
            <input type="text" class="form-control bg-light" 
                   value="{{ auth()->user()->name }}" 
                   readonly disabled>
            <div class="form-text text-muted">
                <i class="fas fa-id-card me-1"></i>
                Nama PIC yang sedang login
            </div>
        </div>

        <!-- TASK -->
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fas fa-tasks me-1 text-primary"></i>
                Task
            </label>
            <input type="text" name="task" class="form-control" 
                   placeholder="Apa yang Anda kerjakan hari ini?" required>
            <div class="form-text text-muted">Contoh: Maintenance server, Update aplikasi, Meeting dengan klien</div>
        </div>

        <!-- DESKRIPSI -->
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fas fa-align-left me-1 text-primary"></i>
                Deskripsi
            </label>
            <textarea name="description" rows="4" class="form-control" 
                      placeholder="Jelaskan detail pekerjaan Anda hari ini..." required></textarea>
            <div class="form-text text-muted">Deskripsikan task dengan jelas dan detail</div>
        </div>

        <!-- GITHUB LINK (HANYA UNTUK DIVISI SOFTWARE HOST) -->
        @if(auth()->user()->division_id == 3)
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fab fa-github me-1 text-dark"></i>
                Link Repository GitHub
                <span class="badge bg-info ms-2">Software Host</span>
                <span class="text-muted fw-normal">(Opsional)</span>
            </label>
            <input type="url" name="github_link" class="form-control" 
                   id="githubLinkDaily"
                   placeholder="https://github.com/username/repository"
                   pattern="https://.*github\.com/.*">
            <small class="text-muted d-block mt-2">
                <i class="fas fa-info-circle me-1"></i>
                Sertakan link repository GitHub jika ada kode yang di-push atau di-update
            </small>
        </div>
        @endif

        <!-- DOKUMENTASI -->
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-camera me-1 text-primary"></i>
                Dokumentasi
            </label>
            <input type="file" name="documentation" class="form-control" 
                   accept="image/*" id="documentationInput">
            <small class="text-muted">Upload gambar (jpg, png, gif - maks. 2MB)</small>
            
            <!-- Preview gambar -->
            <div id="imagePreview" class="mt-2" style="display: none;">
                <img id="previewImage" class="img-thumbnail" style="max-height: 150px;">
            </div>
        </div>

        <!-- VIDEO UPLOAD (HANYA UNTUK DIVISI MULTIMEDIA) -->
        @if(auth()->user()->division_id == 1)
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-video me-1 text-success"></i>
                Video Dokumentasi
                <span class="badge bg-success ms-2">Multimedia</span>
            </label>
            <input type="file" name="video" class="form-control" 
                   accept="video/*" id="videoInput">
            <small class="text-muted d-block mt-2">
                <i class="fas fa-info-circle me-1"></i>
                Upload video (MP4, MOV, AVI, MKV - tanpa batasan ukuran)
            </small>
            
            <!-- Preview video -->
            <div id="videoPreview" class="mt-2" style="display: none;">
                <video id="previewVideo" class="rounded" style="max-width: 100%; max-height: 200px; background: #000;">
                    Browser Anda tidak mendukung HTML5 video
                </video>
            </div>
            
            <!-- Info video yang dipilih -->
            <div id="videoInfo" class="mt-2 alert alert-info" style="display: none;">
                <small>
                    <i class="fas fa-check-circle me-1"></i>
                    <span id="videoFileName"></span> - 
                    <span id="videoFileSize"></span>
                </small>
            </div>
        </div>
        @endif

        <!-- DYNAMIC FIELDS FROM SUPERVISOR SCHEMA -->
        @if(isset($schema) && is_array($schema->schema))
            <div class="dynamic-fields-section mb-4 mt-5 pt-4 border-top">
                <h6 class="fw-bold mb-4 text-primary">
                    <i class="fas fa-list-ul me-2"></i>Informasi Tambahan (Harian)
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
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary btn-lg w-100">
            <i class="fas fa-paper-plane me-2"></i>
            Kirim Daily Report
        </button>
    </form>
</div>

<!-- JavaScript untuk preview gambar dan video -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('documentationInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                
                if (!validTypes.includes(file.type)) {
                    alert('Hanya file gambar (jpg, png, gif) yang diizinkan!');
                    this.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }
                
                // Validasi ukuran file (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    this.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }
                
                // Preview gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }
    
    // Video preview handler (hanya untuk divisi Multimedia)
    const videoInput = document.getElementById('videoInput');
    const videoPreview = document.getElementById('videoPreview');
    const previewVideo = document.getElementById('previewVideo');
    const videoInfo = document.getElementById('videoInfo');
    const videoFileName = document.getElementById('videoFileName');
    const videoFileSize = document.getElementById('videoFileSize');
    
    if (videoInput) {
        videoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
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
                    videoPreview.style.display = 'none';
                    videoInfo.style.display = 'none';
                    return;
                }
                
                // Tampilkan info video
                videoFileName.textContent = file.name;
                videoFileSize.textContent = formatFileSize(file.size);
                videoInfo.style.display = 'block';
                
                // Preview video
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewVideo.src = e.target.result;
                    videoPreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                videoPreview.style.display = 'none';
                videoInfo.style.display = 'none';
            }
        });
    }
    
    // Function untuk format ukuran file
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
});
</script>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .alert-success {
        background-color: #d1e7dd;
        border-color: #badbcc;
        color: #0f5132;
        border-radius: 8px;
        padding: 12px 16px;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .input-group {
        border-radius: 8px;
        overflow: hidden;
    }
    
    h4 {
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #2c3e50;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
        padding: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
    
    #previewImage {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 10px;
    }
    
    /* Video Upload Styling */
    #videoPreview video {
        background: #000;
        width: 100%;
        border-radius: 8px;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        font-weight: 500;
    }
    
    .alert-info {
        background-color: #cfe2ff;
        border-color: #b6d4fe;
        color: #084298;
        border-radius: 8px;
        padding: 10px 12px;
    }
    
    .alert-info small {
        display: flex;
        align-items: center;
    }
    
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        
        h4 {
            font-size: 1.5rem;
        }
        
        .btn-primary {
            padding: 10px;
            font-size: 1rem;
        }
    }
</style>
@endsection