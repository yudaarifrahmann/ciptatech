@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="user-management-wrapper py-3">
    <!-- Header Section -->
    <div class="user-management-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-user-edit fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Edit User</h4>
                        <p class="text-muted mb-0">Ubah data user {{ $user->name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <a href="{{ route('superadmin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-user-edit me-2 text-primary"></i>
                        Form Edit User
                    </h5>
                    <p class="text-muted small mb-0">Perbarui data user sesuai kebutuhan</p>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('superadmin.users.update', $user->id) }}" id="editUserForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1 text-primary"></i>
                                    Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg border-1 shadow-sm" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       placeholder="Masukkan nama lengkap"
                                       required
                                       autofocus>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-1 text-primary"></i>
                                    Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control form-control-lg border-1 shadow-sm" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="nama@perusahaan.com"
                                       required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">Email harus unik dan valid</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-1 text-primary"></i>
                                    Password Baru
                                    <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control form-control-lg border-1 shadow-sm" 
                                           name="password" 
                                           id="passwordInput"
                                           placeholder="Minimal 6 karakter">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordHint">Kosongkan jika tidak ingin mengubah</small>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user-tag me-1 text-primary"></i>
                                    Konfirmasi Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control form-control-lg border-1 shadow-sm" 
                                           name="password_confirmation" 
                                           id="confirmPassword"
                                           placeholder="Ulangi password baru">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text text-muted" id="passwordMatchText"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-shield-alt me-1 text-primary"></i>
                                    Role
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg border-1 shadow-sm" name="role" id="roleSelect">
                                    <option value="PIC" {{ old('role', $user->role) == 'PIC' ? 'selected' : '' }}>PIC</option>
                                    <option value="supervisor" {{ old('role', $user->role) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                    <option value="admin_divisi" {{ old('role', $user->role) == 'admin_divisi' ? 'selected' : '' }}>Admin Divisi</option>
                                </select>
                                <div class="form-text text-muted" id="roleDescription">
                                    Person In Charge - Bertanggung jawab pada tugas divisi
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-building me-1 text-primary"></i>
                                    Divisi
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg border-1 shadow-sm" name="division_id" id="divisionSelect">
                                    <option value="">-- Pilih Divisi --</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" 
                                            {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text text-muted" id="divisionInfo">Pilih divisi tempat user bertugas</div>
                                @error('division_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Info (shown for specific roles) -->
                        <div class="row mb-4" id="additionalInfo" style="display: none;">
                            <div class="col-12">
                                <div class="card border-primary border-opacity-25">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-primary mb-2">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Informasi Tambahan
                                        </h6>
                                        <p class="text-muted small mb-0" id="additionalInfoText">
                                            <!-- Content will be filled by JavaScript -->
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-info border-opacity-25">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="fw-bold text-info mb-1">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Informasi User
                                                </h6>
                                                <p class="text-muted small mb-0">
                                                    Dibuat: {{ $user->created_at->format('d M Y H:i') }} | 
                                                    Terakhir update: {{ $user->updated_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} px-3 py-2 rounded-pill">
                                                    <i class="fas fa-circle fa-xs me-1"></i>
                                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-redo me-1"></i>Reset Form
                            </button>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-lg px-5" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    <span>Update User</span>
                                    <span class="spinner-border spinner-border-sm ms-2" id="submitSpinner" style="display: none;"></span>
                                </button>
                                
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-lg px-4" 
                                        onclick="showDeleteModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->role }}')">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-white border-0 py-3">
                    <div class="alert alert-info border-0 mb-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lightbulb me-2"></i>
                            <div>
                                <small class="fw-bold">Tips:</small>
                                <small class="d-block text-muted">
                                    Hanya isi password jika ingin mengubah password user. 
                                    Kosongkan jika tidak ingin mengubah.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="modal-icon mb-3">
                    <div class="icon-wrapper bg-danger bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Hapus User</h5>
                <p class="text-muted mb-3" id="deleteModalText">
                    <!-- Text will be filled by JavaScript -->
                </p>
                <div class="alert alert-warning border-0 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                        <div>
                            <small class="fw-bold">Peringatan:</small>
                            <small class="d-block text-muted">
                                User yang dihapus tidak dapat dikembalikan. 
                                Semua data terkait user ini akan hilang.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form method="POST" action="" id="deleteForm">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Ya, Hapus User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            User berhasil diupdate.
        </div>
    </div>
</div>

<style>
    .user-management-wrapper {
        padding: 1rem 0;
    }
    
    .user-management-header {
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
    
    .form-control-lg, .form-select-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        border-radius: 8px;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #86b7fe;
    }
    
    .password-strength .progress {
        border-radius: 3px;
    }
    
    @media (max-width: 768px) {
        .user-management-header {
            padding: 1.5rem;
        }
        
        .icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .icon-wrapper i {
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .form-control-lg, .form-select-lg {
            font-size: 1rem;
            padding: 0.625rem 0.875rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
        
        .d-flex.justify-content-between .btn {
            width: 100%;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
    
    @media (max-width: 576px) {
        .user-management-wrapper {
            padding: 0.5rem;
        }
        
        .user-management-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .row > .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .btn-lg {
            padding: 0.75rem 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }
        
        if (toggleConfirmPassword && confirmPassword) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthBar = document.getElementById('passwordStrength');
                const strengthHint = document.getElementById('passwordHint');
                
                if (!password) {
                    strengthBar.style.width = '0%';
                    strengthHint.textContent = 'Kosongkan jika tidak ingin mengubah';
                    return;
                }
                
                let strength = 0;
                let hint = '';
                
                if (password.length >= 6) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;
                
                if (strength <= 25) {
                    strengthBar.className = 'progress-bar bg-danger';
                    hint = 'Lemah';
                } else if (strength <= 50) {
                    strengthBar.className = 'progress-bar bg-warning';
                    hint = 'Cukup';
                } else if (strength <= 75) {
                    strengthBar.className = 'progress-bar bg-info';
                    hint = 'Baik';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    hint = 'Kuat';
                }
                
                strengthBar.style.width = strength + '%';
                strengthHint.textContent = hint + ' • ' + (password.length > 0 ? password.length + ' karakter' : 'Kosongkan jika tidak ingin mengubah');
                
                
                checkPasswordMatch();
            });
        }
        
        if (confirmPassword) {
            confirmPassword.addEventListener('input', checkPasswordMatch);
        }
        
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmPassword.value;
            const matchText = document.getElementById('passwordMatchText');
            
            if (!password) {
                matchText.textContent = 'Isi password baru di atas terlebih dahulu';
                matchText.className = 'form-text text-muted';
                return;
            }
            
            if (!confirm) {
                matchText.textContent = 'Konfirmasi password baru';
                matchText.className = 'form-text text-muted';
                return;
            }
            
            if (password === confirm) {
                matchText.textContent = '✓ Password cocok';
                matchText.className = 'form-text text-success fw-bold';
            } else {
                matchText.textContent = '✗ Password tidak cocok';
                matchText.className = 'form-text text-danger fw-bold';
            }
        }
        
        const roleSelect = document.getElementById('roleSelect');
        const roleDescription = document.getElementById('roleDescription');
        const additionalInfo = document.getElementById('additionalInfo');
        const additionalInfoText = document.getElementById('additionalInfoText');
        const divisionSelect = document.getElementById('divisionSelect');
        
        if (roleSelect) {
            roleSelect.addEventListener('change', function() {
                const role = this.value;
               
                let description = '';
                let infoText = '';
                let showAdditional = false;
                
                switch(role) {
                    case 'PIC':
                        description = 'Person In Charge - Bertanggung jawab pada tugas divisi tertentu';
                        infoText = 'PIC akan bertanggung jawab pada laporan tugas di divisi yang dipilih. Mereka dapat membuat dan mengirim laporan progress.';
                        showAdditional = true;
                        divisionSelect.disabled = false;
                        break;
                    case 'supervisor':
                        description = 'Supervisor - Memantau progress dan menyetujui laporan';
                        infoText = 'Supervisor memiliki akses untuk memantau semua divisi, menyetujui laporan, dan mengelola akun PIC.';
                        showAdditional = true;
                        divisionSelect.disabled = true;
                        break;
                    case 'admin_divisi':
                        description = 'Admin Divisi - Mengelola divisi dan anggotanya';
                        infoText = 'Admin Divisi bertanggung jawab mengelola anggota divisi dan koordinasi internal divisi.';
                        showAdditional = true;
                        divisionSelect.disabled = false;
                        break;
                }
                
                roleDescription.textContent = description;
                additionalInfoText.textContent = infoText;
                
                if (showAdditional) {
                    additionalInfo.style.display = 'block';
                } else {
                    additionalInfo.style.display = 'none';
                }
                
                const divisionInfo = document.getElementById('divisionInfo');
                if (role === 'supervisor') {
                    divisionInfo.textContent = 'Supervisor dapat mengakses semua divisi';
                    divisionInfo.className = 'form-text text-info';
                } else {
                    divisionInfo.textContent = 'Pilih divisi tempat user bertugas';
                    divisionInfo.className = 'form-text text-muted';
                }
            });
            
            roleSelect.dispatchEvent(new Event('change'));
        }
        
        const editUserForm = document.getElementById('editUserForm');
        if (editUserForm) {
            editUserForm.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirm = confirmPassword.value;
                
                if (password && password !== confirm) {
                    e.preventDefault();
                    showToast('Password tidak cocok! Silahkan periksa kembali.', 'error');
                    return;
                }
           
                const role = roleSelect.value;
                const division = divisionSelect.value;
                
                if (role !== 'supervisor' && !division) {
                    e.preventDefault();
                    showToast('Silahkan pilih divisi untuk user ini.', 'error');
                    return;
                }
                
                const submitBtn = document.getElementById('submitBtn');
                const spinner = document.getElementById('submitSpinner');
                const submitText = submitBtn.querySelector('span:first-of-type');
                
                submitText.textContent = 'Memperbarui...';
                spinner.style.display = 'inline-block';
                submitBtn.disabled = true;
            });
        }
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('successToast');
            const toastBody = toastEl.querySelector('.toast-body');
            
            toastBody.textContent = message;
            
            if (type === 'error') {
                toastEl.querySelector('.toast-header').className = 'toast-header bg-danger text-white';
                toastEl.querySelector('.toast-header i').className = 'fas fa-exclamation-circle me-2';
                toastEl.querySelector('.toast-header strong').textContent = 'Error';
            } else {
                toastEl.querySelector('.toast-header').className = 'toast-header bg-success text-white';
                toastEl.querySelector('.toast-header i').className = 'fas fa-check-circle me-2';
                toastEl.querySelector('.toast-header strong').textContent = 'Berhasil';
            }
            
            successToast.show();
        }
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    });
    
    function showDeleteModal(userId, userName, userRole) {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');
        const deleteModalText = document.getElementById('deleteModalText');
        
        deleteModalText.textContent = `Apakah Anda yakin ingin menghapus user "${userName}" (${userRole})?`;
        
        deleteForm.action = `/superadmin/users/${userId}`;
        
        deleteModal.show();
    }
</script>
@endsection