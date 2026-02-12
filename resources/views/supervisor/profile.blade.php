@extends('layouts.app')

@section('title', 'Profile')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal" class="list-group-item list-group-item-action border-0 py-3 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="option-icon me-3">
                                        <div class="icon-wrapper bg-warning bg-opacity-10 p-2 rounded-circle">
                                            <i class="fas fa-key text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Ganti Password</h6>
                                        <p class="text-muted small mb-0">Update password akun Anda secara berkala</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                            
                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginActivityModal" class="list-group-item list-group-item-action border-0 py-3 px-0">
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

    });

    // Toggle password visibility
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const isPassword = field.type === 'password';
        field.type = isPassword ? 'text' : 'password';
        
        // Update button icon
        event.target.closest('button').innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
    }

    // Check password strength
    function checkPasswordStrength() {
        const password = document.getElementById('newPassword').value;
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 10;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
        if (/\d/.test(password)) strength += 25;
        if (/[^a-zA-Z\d]/.test(password)) strength += 20;
        
        strengthBar.style.width = strength + '%';
        strengthBar.setAttribute('aria-valuenow', strength);
        
        let strengthLevel = 'Lemah';
        let strengthColor = 'bg-danger';
        
        if (strength >= 80) {
            strengthLevel = 'Sangat Kuat';
            strengthColor = 'bg-success';
        } else if (strength >= 60) {
            strengthLevel = 'Kuat';
            strengthColor = 'bg-info';
        } else if (strength >= 40) {
            strengthLevel = 'Sedang';
            strengthColor = 'bg-warning';
        }
        
        strengthBar.className = 'progress-bar ' + strengthColor;
        strengthText.innerHTML = '<i class="fas fa-shield-alt me-1"></i>Kekuatan password: <strong>' + strengthLevel + '</strong>';
        
        checkPasswordMatch();
    }

    // Check password match
    function checkPasswordMatch() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const matchText = document.getElementById('matchText');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        
        if (confirmPassword.length === 0) {
            matchText.innerHTML = '<i class="fas fa-info-circle me-1"></i>Password harus sama dengan password baru';
            matchText.className = 'text-muted d-block mt-2';
            changePasswordBtn.disabled = false;
            return;
        }
        
        if (newPassword === confirmPassword) {
            matchText.innerHTML = '<i class="fas fa-check-circle me-1 text-success"></i><strong class="text-success">Password cocok!</strong>';
            matchText.className = 'text-success d-block mt-2';
            changePasswordBtn.disabled = false;
        } else {
            matchText.innerHTML = '<i class="fas fa-times-circle me-1 text-danger"></i><strong class="text-danger">Password tidak cocok!</strong>';
            matchText.className = 'text-danger d-block mt-2';
            changePasswordBtn.disabled = true;
        }
    }

</script>

<!-- Modal Edit Profil -->
<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('supervisor.profile.update') }}">
                @csrf
                @method('PUT')

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title">Edit Informasi Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ $user->email }}" required>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form method="POST" action="{{ route('supervisor.profile.password') }}" id="changePasswordForm">
                @csrf
                @method('PUT')

                <!-- HEADER -->
                <div class="modal-header bg-light border-0">
                    <div>
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-lock me-2 text-warning"></i>
                            Ganti Password
                        </h5>
                        <small class="text-muted">Masukkan password saat ini dan password baru Anda</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Gagal mengubah password!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Password Saat Ini -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-key me-1 text-warning"></i>
                            Password Saat Ini
                        </label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control form-control-lg" 
                                   id="currentPassword"
                                   placeholder="Masukkan password saat ini"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('currentPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Untuk keamanan, kami meminta Anda mengkonfirmasi password saat ini
                        </small>
                    </div>

                    <hr class="my-4">

                    <!-- Password Baru -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-lock me-1 text-success"></i>
                            Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control form-control-lg" 
                                   id="newPassword"
                                   placeholder="Masukkan password baru"
                                   minlength="8"
                                   required
                                   oninput="checkPasswordStrength()">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('newPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Minimal 8 karakter
                        </small>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mb-4">
                        <div class="password-strength-indicator">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small id="strengthText" class="text-muted d-block mt-1">
                                Kekuatan password akan ditampilkan di sini
                            </small>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-check-circle me-1 text-info"></i>
                            Konfirmasi Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" 
                                   id="confirmPassword"
                                   placeholder="Ketik ulang password baru"
                                   required
                                   oninput="checkPasswordMatch()">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirmPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small id="matchText" class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Password harus sama dengan password baru
                        </small>
                    </div>

                    <!-- Password Requirements -->
                    <div class="alert alert-info alert-dismissible fade show border-0" role="alert" style="font-size: 0.9rem;">
                        <strong><i class="fas fa-shield-alt me-1"></i>Persyaratan Password:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            <li>Minimal 8 karakter</li>
                            <li>Kombinasi huruf besar, huruf kecil, angka, dan simbol lebih aman</li>
                            <li>Jangan gunakan informasi pribadi (nama, tanggal lahir, dll)</li>
                        </ul>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                        <i class="fas fa-check me-1"></i>
                        Ubah Password
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

<!-- Modal Login Activity -->
<div class="modal fade" id="loginActivityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aktivitas Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="loginActivityList">
                    <div class="text-center text-muted py-4">
                        Memuat aktivitas...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginModal = document.getElementById('loginActivityModal');
        if (!loginModal) return;

        loginModal.addEventListener('show.bs.modal', function () {
            const container = document.getElementById('loginActivityList');
            container.innerHTML = '<div class="text-center text-muted py-4">Memuat aktivitas...</div>';

            fetch("{{ route('supervisor.profile.loginActivity') }}")
                .then(res => res.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        container.innerHTML = '<div class="text-center text-muted py-4">Belum ada aktivitas login</div>';
                        return;
                    }

                    const list = document.createElement('div');
                    list.className = 'list-group';

                    data.forEach(item => {
                        const desc = item.description || '';
                        const time = new Date(item.created_at).toLocaleString();

                        const el = document.createElement('div');
                        el.className = 'list-group-item d-flex justify-content-between align-items-start';
                        el.innerHTML = `
                            <div>
                                <div class="fw-bold">${desc}</div>
                                <div class="text-muted small">${item.properties?.ip ?? ''} ${item.properties?.user_agent ? '• ' + item.properties.user_agent : ''}</div>
                            </div>
                            <div class="text-muted small">${time}</div>
                        `;

                        list.appendChild(el);
                    });

                    container.innerHTML = '';
                    container.appendChild(list);
                })
                .catch(err => {
                    container.innerHTML = '<div class="text-center text-danger py-4">Gagal memuat aktivitas</div>';
                    console.error(err);
                });
        });
    });
</script>