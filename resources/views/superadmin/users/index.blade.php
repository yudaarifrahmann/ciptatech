@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="user-management-wrapper py-3">
    <!-- Header Section -->
    <div class="user-management-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Manajemen User</h4>
                        <p class="text-muted mb-0">Kelola semua user dalam sistem</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i>Tambah User
                </a>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total User</h6>
                            <h2 class="fw-bold mb-0">{{ $users->count() }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-2x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                @php
                    $picCount = $users->where('role', 'PIC')->count();
                @endphp
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">PIC</h6>
                            <h2 class="fw-bold mb-0">{{ $picCount }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-check fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                @php
                    $supervisorCount = $users->where('role', 'supervisor')->count();
                @endphp
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Supervisor</h6>
                            <h2 class="fw-bold mb-0">{{ $supervisorCount }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-tie fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                @php
                    $adminCount = $users->where('role', 'admin_divisi')->count();
                @endphp
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Admin Divisi</h6>
                            <h2 class="fw-bold mb-0">{{ $adminCount }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-shield fa-2x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="fas fa-table me-2 text-primary"></i>
                        Daftar User
                    </h5>
                    <p class="text-muted small mb-0">Semua user yang terdaftar dalam sistem</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 shadow-none" placeholder="Cari user..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">
                                <div class="d-flex align-items-center">
                                    <span>Nama</span>
                                    <button class="btn btn-link btn-sm p-0 ms-1">
                                        <i class="fas fa-sort text-muted"></i>
                                    </button>
                                </div>
                            </th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Sample data for demo if $users is empty
                            $sampleUsers = [
                                (object)[
                                    'id' => 1,
                                    'name' => 'Andi Wijaya',
                                    'email' => 'andi@company.com',
                                    'role' => 'PIC',
                                    'division' => (object)['name' => 'Multimedia'],
                                    'is_active' => true,
                                    'email_verified_at' => now()
                                ],
                                (object)[
                                    'id' => 2,
                                    'name' => 'Budi Santoso',
                                    'email' => 'budi@company.com',
                                    'role' => 'supervisor',
                                    'division' => null,
                                    'is_active' => true,
                                    'email_verified_at' => now()
                                ],
                                (object)[
                                    'id' => 3,
                                    'name' => 'Siti Nurhaliza',
                                    'email' => 'siti@company.com',
                                    'role' => 'admin_divisi',
                                    'division' => (object)['name' => 'IT Support'],
                                    'is_active' => true,
                                    'email_verified_at' => null
                                ],
                                (object)[
                                    'id' => 4,
                                    'name' => 'Cici Permata',
                                    'email' => 'cici@company.com',
                                    'role' => 'PIC',
                                    'division' => (object)['name' => 'Network'],
                                    'is_active' => false,
                                    'email_verified_at' => now()
                                ]
                            ];
                            
                            $displayUsers = $users ?? collect($sampleUsers);
                        @endphp
                        
                        @foreach($displayUsers as $user)
                        <tr data-user-id="{{ $user->id ?? $loop->index }}">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder me-3">
                                        @php
                                            $roleColor = match($user->role) {
                                                'PIC' => 'primary',
                                                'supervisor' => 'warning',
                                                'admin_divisi' => 'info',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <div class="avatar bg-{{ $roleColor }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-{{ $roleColor }}"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <strong class="d-block">{{ $user->name }}</strong>
                                        <small class="text-muted">ID: USER-{{ str_pad($user->id ?? $loop->iteration, 3, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="email-info">
                                    <strong class="d-block">{{ $user->email }}</strong>
                                    <small class="text-muted">
                                        @if($user->email_verified_at ?? false)
                                            <i class="fas fa-check-circle text-success me-1"></i>Terverifikasi
                                        @else
                                            <i class="fas fa-clock text-warning me-1"></i>Belum verifikasi
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleBadge = match($user->role) {
                                        'PIC' => ['color' => 'primary', 'icon' => 'user-check', 'text' => 'PIC'],
                                        'supervisor' => ['color' => 'warning', 'icon' => 'user-tie', 'text' => 'Supervisor'],
                                        'admin_divisi' => ['color' => 'info', 'icon' => 'user-shield', 'text' => 'Admin Divisi'],
                                        default => ['color' => 'secondary', 'icon' => 'user', 'text' => $user->role]
                                    };
                                @endphp
                                <span class="badge bg-{{ $roleBadge['color'] }} bg-opacity-10 text-{{ $roleBadge['color'] }} border border-{{ $roleBadge['color'] }} border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-{{ $roleBadge['icon'] }} me-1"></i>{{ $roleBadge['text'] }}
                                </span>
                            </td>
                            <td>
                                @if($user->division && isset($user->division->name))
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        <i class="fas fa-building me-1"></i>{{ $user->division->name }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $isActive = $user->is_active ?? true;
                                    $status = $isActive ? ['color' => 'success', 'icon' => 'circle', 'text' => 'Aktif'] 
                                                       : ['color' => 'secondary', 'icon' => 'circle', 'text' => 'Nonaktif'];
                                @endphp
                                <span class="badge bg-{{ $status['color'] }} bg-opacity-10 text-{{ $status['color'] }} border border-{{ $status['color'] }} border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-{{ $status['icon'] }} fa-xs me-1"></i>{{ $status['text'] }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('superadmin.users.edit', $user->id ?? '#') }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button class="btn btn-outline-info btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Reset Password"
                                            onclick="showResetPasswordModal('{{ $user->id ?? $loop->index }}', '{{ $user->name }}')">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    
                                    <button class="btn btn-outline-{{ $isActive ? 'warning' : 'success' }} btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="{{ $isActive ? 'Nonaktifkan' : 'Aktifkan' }}"
                                            onclick="toggleUserStatus('{{ $user->id ?? $loop->index }}', '{{ $user->name }}', {{ $isActive ? 'true' : 'false' }})">
                                        <i class="fas fa-{{ $isActive ? 'user-slash' : 'user-check' }}"></i>
                                    </button>
                                    
                                    <button class="btn btn-outline-danger btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Hapus User"
                                            onclick="showDeleteModal('{{ $user->id ?? $loop->index }}', '{{ $user->name }}', '{{ $user->role }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-2 mb-md-0">
                    <p class="text-muted small mb-0">
                        Menampilkan {{ $displayUsers->count() }} user
                    </p>
                </div>
                <!-- Pagination removed since we're using Collection -->
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if($displayUsers->count() == 0)
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 text-center">
            <div class="empty-state">
                <div class="empty-icon mb-4">
                    <i class="fas fa-users fa-4x text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold mb-3">Belum ada user</h5>
                <p class="text-muted mb-4">Tambahkan user pertama Anda untuk mulai menggunakan sistem</p>
                <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i>Tambah User Pertama
                </a>
            </div>
        </div>
    </div>
    @endif
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

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="text-muted mb-4" id="resetPasswordText">
                    <!-- Text will be filled by JavaScript -->
                </p>
                <div class="alert alert-info border-0 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            <small>Password baru akan dikirim ke email user</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form method="POST" action="" id="resetPasswordForm">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key me-1"></i>Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Operasi berhasil dilakukan.
        </div>
    </div>
    
    <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Terjadi kesalahan. Silakan coba lagi.
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
    
    .stat-card {
        transition: transform 0.2s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    
    .stat-card h2 {
        font-size: 2rem;
        line-height: 1;
    }
    
    .stat-icon {
        opacity: 0.8;
    }
    
    .card {
        border-radius: 12px;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        color: #6c757d;
        border-top: none;
        padding: 1rem;
        vertical-align: middle;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem;
        border-top: 1px solid #f1f1f1;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    
    .avatar {
        flex-shrink: 0;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin-right: 4px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .modal-icon .icon-wrapper {
        width: 60px;
        height: 60px;
        margin: 0 auto;
    }
    
    .empty-state {
        padding: 3rem 1rem;
    }
    
    .empty-icon {
        opacity: 0.5;
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
        
        .stat-card {
            padding: 1.25rem !important;
        }
        
        .stat-card h2 {
            font-size: 1.75rem;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .header-actions .btn {
            width: 100%;
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .table th, .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .btn-group {
            flex-wrap: nowrap;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .avatar {
            width: 32px !important;
            height: 32px !important;
            margin-right: 0.75rem !important;
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
        
        .card-body {
            padding: 0 !important;
        }
        
        .btn-sm {
            font-size: 0.75rem;
        }
        
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-body {
            padding: 1rem !important;
        }
        
        .empty-state {
            padding: 2rem 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Initialize toasts
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearch');
        const tableRows = document.querySelectorAll('#usersTable tbody tr');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
                
                clearSearchBtn.style.display = searchTerm ? 'block' : 'none';
            });
        }
        
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                this.style.display = 'none';
                searchInput.focus();
            });
            
            clearSearchBtn.style.display = 'none';
        }
        
        // Row click handler (except action buttons)
        tableRows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.btn') && !e.target.closest('.badge')) {
                    const userId = this.getAttribute('data-user-id');
                    console.log(`View user details: ${userId}`);
                    // In real app, this would redirect to user detail page
                }
            });
        });
        
        // Handle form submissions
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menghapus...';
                submitBtn.disabled = true;
                
                // Allow form to submit to backend
                // Form will redirect on success
            });
        }
        
        const resetPasswordForm = document.getElementById('resetPasswordForm');
        if (resetPasswordForm) {
            resetPasswordForm.addEventListener('submit', function(e) {
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';
                submitBtn.disabled = true;
                
                // Allow form to submit to backend
                // Form will redirect on success
            });
        }
    });
    
    // Show delete confirmation modal
    function showDeleteModal(userId, userName, userRole) {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');
        const deleteModalText = document.getElementById('deleteModalText');
        
        // Set modal text
        deleteModalText.textContent = `Apakah Anda yakin ingin menghapus user "${userName}" (${userRole})?`;
        
        // Set form action with proper route
        deleteForm.action = `{{ route('superadmin.users.index') }}/${userId}`;
        
        deleteModal.show();
    }

    function showResetPasswordModal(userId, userName) {
        const resetModal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
        const resetForm = document.getElementById('resetPasswordForm');
        const resetModalText = document.getElementById('resetPasswordText');
        
        resetModalText.textContent = `Reset password untuk user "${userName}"? Password baru akan dikirim ke email user.`;
        
        // Set form action - using a proper endpoint
        resetForm.action = `{{ route('superadmin.users.index') }}/${userId}/reset-password`;
        
        resetModal.show();
    }
  
    function toggleUserStatus(userId, userName, isActive) {
        const action = isActive ? 'nonaktifkan' : 'aktifkan';
        const confirmText = `Apakah Anda yakin ingin ${action} user "${userName}"?`;
        
        if (confirm(confirmText)) {
            // Create and submit a hidden form to toggle status
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ route('superadmin.users.index') }}/${userId}/toggle-status`;
            form.style.display = 'none';
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                input.value = csrfToken.getAttribute('content');
                form.appendChild(input);
            }
            
            // Add PATCH method
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function showToast(message, type = 'success') {
        const toastEl = document.getElementById(type === 'success' ? 'successToast' : 'errorToast');
        const toastBody = toastEl.querySelector('.toast-body');
        
        toastBody.textContent = message;
        
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
    
    function updateUserCount() {
        const totalCount = document.querySelector('.stat-card:nth-child(1) h2');
        const picCount = document.querySelector('.stat-card:nth-child(2) h2');
        const supervisorCount = document.querySelector('.stat-card:nth-child(3) h2');
        const adminCount = document.querySelector('.stat-card:nth-child(4) h2');
        
        if (totalCount) {
            const current = parseInt(totalCount.textContent);
            totalCount.textContent = current - 1;
        }
    }
</script>
@endsection