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

        <button type="submit" class="btn btn-primary btn-lg w-100">
            <i class="fas fa-paper-plane me-2"></i>
            Kirim Daily Report
        </button>
    </form>
</div>

<!-- JavaScript untuk preview gambar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('documentationInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
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
});

// Tambahkan CSS untuk tampilan yang lebih baik
const style = document.createElement('style');
style.textContent = `
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
    
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    #previewImage {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 10px;
    }
`;
document.head.appendChild(style);
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