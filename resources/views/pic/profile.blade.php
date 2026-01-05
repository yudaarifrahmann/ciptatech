@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="profile-wrapper py-3">
    <!-- Header Section -->
    <div class="profile-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Profile PIC</h4>
                        <p class="text-muted mb-0">Kelola informasi akun dan keamanan Anda</p>
                    </div>
                </div>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-circle fa-xs me-1"></i>
                    <span>Online</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user-circle me-2 text-primary"></i>
                        Informasi Profil
                    </h5>
                    <p class="text-muted small mb-0">Data pribadi dan informasi akun</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- foto -->
<div class="col-md-3 text-center mb-4 mb-md-0">
    <div class="profile-picture mx-auto mb-3">
        <div class="avatar-placeholder">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    </div>
</div>       
                                            <!-- info -->
                     <div class="col-md-9">
                        <div class="profile-details">
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label text-muted small mb-1">
                                        <i class="fas fa-user me-1"></i>Nama Lengkap </label>
                                        <div class="info-box bg-light rounded-3 p-3">
                                            <strong class="d-block">{{ $user->name }}</strong>
                                        </div> </div> <div class="col-sm-6 mb-3">
                                            <label class="form-label text-muted small mb-1">
                                                <i class="fas fa-envelope me-1"></i>Email </label>
                                                <div class="info-box bg-light rounded-3 p-3">
                                                    <strong class="d-block">{{ $user->email }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label text-muted small mb-1">
                                                    <i class="fas fa-user-tag me-1"></i>Role </label>
                                                    <div class="info-box bg-light rounded-3 p-3">
                                                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                                                            <i class="fas fa-shield-alt me-1"></i>{{ $user->role }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <label class="form-label text-muted small mb-1">
                                                        <i class="fas fa-calendar-alt me-1"></i>Bergabung Sejak </label>
                                                        <div class="info-box bg-light rounded-3 p-3">
                                                            <strong class="d-block">
    {{ $user->created_at->translatedFormat('d F Y') }}
</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 mb-3">
                                                        <label class="form-label text-muted small mb-1">
                                                            <i class="fas fa-id-card me-1"></i>ID Pengguna </label>
                                                            <div class="info-box bg-light rounded-3 p-3">
                                                                <code class="text-primary">PIC-{{ str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) }}</code>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 mb-3">
                                                            <label class="form-label text-muted small mb-1">
                                                                <i class="fas fa-building me-1"></i>Divisi</label>
                                                                <div class="info-box bg-light rounded-3 p-3">
                                                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
    {{ $user->division->name ?? 'Belum ada divisi' }}
</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-shield-alt me-2 text-success"></i>
                        Keamanan Akun
                    </h5>
                    <p class="text-muted small mb-0">Pengaturan keamanan dan privasi</p>
                </div>
                <div class="card-body">
                    <div class="security-status mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Keamanan Akun</span>
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle me-1"></i>Aman
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="security-options">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action border-0 py-3 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="option-icon me-3">
                                        <div class="icon-wrapper bg-warning bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-key text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Ganti Password</h6>
                                        <p class="text-muted small mb-0">Terakhir diubah 30 hari lalu</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action border-0 py-3 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="option-icon me-3">
                                        <div class="icon-wrapper bg-info bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-mobile-alt text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Autentikasi 2 Faktor</h6>
                                        <p class="text-muted small mb-0">Aktifkan untuk keamanan ekstra</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch">
                                    </div>
                                </div>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action border-0 py-3 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="option-icon me-3">
                                        <div class="icon-wrapper bg-danger bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-history text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Aktivitas Login</h6>
                                        <p class="text-muted small mb-0">Riwayat login akun Anda</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action border-0 py-3 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="option-icon me-3">
                                        <div class="icon-wrapper bg-primary bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-bell text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Notifikasi</h6>
                                        <p class="text-muted small mb-0">Atur preferensi notifikasi</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-history me-2 text-info"></i>
                        Aktivitas Terbaru
                    </h5>
                    <p class="text-muted small mb-0">Aktivitas terkini dari akun Anda</p>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-file-upload text-primary"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Mengupload laporan tugas</h6>
                                <p class="text-muted small mb-0">Implementasi Login System</p>
                                <small class="text-muted">3 Januari 2026, 10:30 AM</small>
                            </div>
                        </div>   
                        @foreach($activities as $log)
<div class="timeline-item">
    <h6>{{ $log->description }}</h6>
    <small>{{ $log->created_at->diffForHumans() }}</small>
</div>
@endforeach
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i>Lihat Semua Aktivitas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-wrapper {
        padding: 1rem 0;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 12px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
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
    
    .card {
        border-radius: 12px;
    }
    
    .avatar-placeholder {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    
    .info-box {
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    
    .info-box:hover {
        border-color: #dee2e6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .security-status .progress {
        border-radius: 10px;
    }
    
    .security-options .list-group-item {
        transition: all 0.2s ease;
    }
    
    .security-options .list-group-item:hover {
        background-color: rgba(13, 110, 253, 0.03);
        transform: translateX(5px);
    }
    
    .option-icon .icon-wrapper {
        width: 45px;
        height: 45px;
    }
    
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-icon {
        position: absolute;
        left: -40px;
        top: 0;
        width: 40px;
        height: 40px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    
    .timeline-content {
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #f1f1f1;
    }
    
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
    }
    
    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem;
        }
        
        .icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .icon-wrapper i {
            font-size: 1.5rem;
        }
        
        .avatar-placeholder {
            width: 100px;
            height: 100px;
        }
        
        .info-box {
            padding: 1rem !important;
        }
        
        .timeline {
            padding-left: 30px;
        }
        
        .timeline:before {
            left: 15px;
        }
        
        .timeline-icon {
            left: -30px;
            width: 30px;
            height: 30px;
        }
        
        .timeline-icon i {
            font-size: 0.875rem;
        }
        
        .card-body {
            padding: 1.25rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .profile-wrapper {
            padding: 0.5rem;
        }
        
        .profile-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .row > .col-md-9 {
            padding-left: 0;
        }
        
        .info-box {
            margin-bottom: 1rem;
        }
        
        .timeline-content {
            padding: 0.75rem 0.5rem;
        }
        
        .security-options .list-group-item {
            padding: 0.75rem 0;
        }
        
        .option-icon .icon-wrapper {
            width: 40px;
            height: 40px;
        }
    }

    .avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: #fff;
    font-size: 48px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    user-select: none;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordBtn = document.querySelector('.btn-outline-primary');
        if (passwordBtn) {
            passwordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Change password clicked');
            });
        }
        
        const twoFactorSwitch = document.querySelector('.form-check-input');
        if (twoFactorSwitch) {
            twoFactorSwitch.addEventListener('change', function() {
                if (this.checked) {
                    alert('Autentikasi 2 Faktor diaktifkan');
                } else {
                    alert('Autentikasi 2 Faktor dinonaktifkan');
                }
            });
        }

        const editBtn = document.querySelector('.btn-primary');
        if (editBtn && editBtn.textContent.includes('Edit Profil')) {
            editBtn.addEventListener('click', function() {
                alert('Fitur edit profil akan dibuka');
            });
        }
    });
</script>
@endsection