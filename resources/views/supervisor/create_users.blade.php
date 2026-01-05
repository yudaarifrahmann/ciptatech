@extends('layouts.app')

@section('title', 'Kelola Akun PIC')

@section('content')
    <div class="account-management-wrapper py-3">
        <!-- Header Section -->
        <div class="account-management-header mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="header-content">
                    <div class="d-flex align-items-center mb-3">
                        <div class="header-icon me-3">
                            <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                                <i class="fas fa-user-plus fa-2x text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Kelola Akun PIC</h4>
                            <p class="text-muted mb-0">Buat dan kelola akun Person In Charge (PIC) untuk setiap divisi</p>
                        </div>
                    </div>
                </div>

                <div class="header-stats mt-3 mt-md-0">
                    <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                        <i class="fas fa-users me-1"></i>
                        <span>Total: <strong id="totalUsers">{{ $totalPIC }}</strong> PIC</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total PIC</h6>
                            <h2 class="fw-bold mb-0">{{ $totalPIC }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-2x text-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Aktif</h6>
                            <h2 class="fw-bold mb-0">{{ $aktif }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-check fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Nonaktif</h6>
                            <h2 class="fw-bold mb-0">{{ $nonaktif }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-slash fa-2x text-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Divisi</h6>
                            <h2 class="fw-bold mb-0">5</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-building fa-2x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </br>

        <div class="row">
            <!-- Create Account Form -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-1">
                            <i class="fas fa-user-plus me-2 text-primary"></i>
                            Buat Akun PIC Baru
                        </h5>
                        <p class="text-muted small mb-0">Tambahkan PIC baru untuk manajemen tugas</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('supervisor.users.store') }}" id="createUserForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1 text-primary"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" class="form-control border-1 shadow-sm" name="name"
                                    placeholder="Masukkan nama lengkap" required>
                                <div class="form-text text-muted">Contoh: Andi Wijaya</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-1 text-primary"></i>
                                    Email
                                </label>
                                <input type="email" class="form-control border-1 shadow-sm" name="email"
                                    placeholder="Masukkan email kamu" required>
                                <div class="form-text text-muted">Email harus unik dan valid</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-1 text-primary"></i>
                                    Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-1 shadow-sm" name="password"
                                        id="passwordInput" placeholder="Minimal 8 karakter" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar"
                                            style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordHint">Kekuatan password</small>
                                </div>
                            </div>

                            <div class="mb-4">
    <label class="form-label fw-bold">
        <i class="fas fa-building me-1 text-primary"></i>
        Divisi
    </label>
    <select class="form-select border-1 shadow-sm" name="division_id" required> 
        <option value="">Pilih Divisi</option>
        
        @foreach ($divisions as $division)
            <option value="{{ $division->id }}">
                {{ $division->name }}
            </option>
        @endforeach

    </select>
    <div class="form-text text-muted">Divisi tempat PIC bertugas</div>
</div>
                            <input type="hidden" name="role" value="PIC">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    <span>Simpan Akun</span>
                                    <span class="spinner-border spinner-border-sm ms-2" id="submitSpinner"
                                        style="display: none;"></span>
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo me-1"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="alert alert-info border-0 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <small class="fw-bold">Informasi:</small>
                                    <small class="d-block text-muted">Password akan dikirim ke email PIC yang
                                        bersangkutan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accounts List -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    <i class="fas fa-users me-2 text-primary"></i>
                                    Daftar Akun PIC
                                </h5>
                                <p class="text-muted small mb-0">Semua akun PIC yang telah dibuat</p>
                            </div>
                            <div class="mt-2 mt-md-0">
                                <div class="input-group" style="max-width: 250px;">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 shadow-none"
                                        placeholder="Cari PIC...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-arrow-rotate-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nama</th>
                                        <th>Email</th>
                                        <th>Divisi</th>
                                        <th>Status</th>
                                        <th>Bergabung</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTableBody">
                                    <!-- Data -->
                                <tbody>
                                    @forelse ($pics as $pic)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-placeholder bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                        style="width:40px;height:40px;">
                                                        {{ strtoupper(substr($pic->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $pic->name }}</strong>
                                                        <small
                                                            class="text-muted">PIC-{{ str_pad($pic->id, 3, '0', STR_PAD_LEFT) }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <strong>{{ $pic->email }}</strong><br>
                                                <small class="text-muted">
                                                    {{ $pic->email_verified_at ? 'Email terverifikasi' : 'Belum verifikasi' }}
                                                </small>
                                            </td>

                                            <td>
                                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                                    {{ $pic->division->name ?? '-' }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($pic->is_active)
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <small>{{ $pic->created_at->translatedFormat('d M Y') }}</small><br>
                                                <small class="text-muted">{{ $pic->created_at->diffForHumans() }}</small>
                                            </td>

                                            <td class="text-end pe-4">
                                                <div class="btn-group">
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                    <button class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Tidak ada PIC di divisi ini
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-2 mb-md-0">
                                <p class="text-muted small mb-0">Menampilkan 4 dari 8 akun PIC</p>
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .account-management-wrapper {
            padding: 1rem 0;
        }

        .account-management-header {
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

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: #86b7fe;
        }

        .password-strength .progress {
            border-radius: 2px;
        }

        .avatar-placeholder {
            flex-shrink: 0;
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

        .btn-group .btn {
            border-radius: 6px !important;
            margin-right: 4px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            min-width: 32px;
            text-align: center;
        }

        .stat-card {
            transition: transform 0.2s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .stat-card h2 {
            font-size: 2rem;
            line-height: 1;
        }

        .stat-icon {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .account-management-header {
                padding: 1.5rem;
            }

            .icon-wrapper {
                width: 60px;
                height: 60px;
            }

            .icon-wrapper i {
                font-size: 1.5rem;
            }

            .table-responsive {
                border-radius: 8px;
                border: 1px solid #dee2e6;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }

            .btn-group {
                flex-wrap: nowrap;
            }

            .btn-group .btn {
                padding: 0.25rem 0.5rem;
            }

            .avatar-placeholder {
                width: 32px !important;
                height: 32px !important;
                margin-right: 0.75rem !important;
            }

            .stat-card {
                padding: 1.25rem !important;
                margin-bottom: 1rem;
            }

            .stat-card h2 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 576px) {
            .account-management-wrapper {
                padding: 0.5rem;
            }

            .account-management-header {
                padding: 1.25rem;
                margin-bottom: 1.5rem;
            }

            .row>.col-lg-4,
            .row>.col-lg-8 {
                padding-left: 0;
                padding-right: 0;
            }

            .card-body {
                padding: 1rem !important;
            }

            .card-header,
            .card-footer {
                padding: 1rem !important;
            }

            .btn-sm {
                font-size: 0.75rem;
            }

            .d-grid.gap-2 {
                gap: 0.5rem !important;
            }

            .input-group {
                width: 100% !important;
                max-width: none !important;
            }

            .pagination {
                margin-top: 1rem;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;
                const strengthBar = document.getElementById('passwordStrength');
                const strengthHint = document.getElementById('passwordHint');

                let strength = 0;
                let hint = '';

                if (password.length >= 8) strength += 25;
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
                strengthHint.textContent = hint + ' • ' + (password.length > 0 ? password.length + ' karakter' : 'Kekuatan password');
            });
        }

        const createUserForm = document.getElementById('createUserForm');
        if (createUserForm) {
            createUserForm.addEventListener('submit', function (e) {
                const submitBtn = document.getElementById('submitBtn');
                const spinner = document.getElementById('submitSpinner');
                const originalText = submitBtn.querySelector('span:first-of-type').textContent;

                submitBtn.querySelector('span:first-of-type').textContent = 'Memproses...';
                spinner.style.display = 'inline-block';
                submitBtn.disabled = true;
            });
        }

        const actionButtons = document.querySelectorAll('.btn-group .btn');
        actionButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const row = this.closest('tr');
                const userName = row.querySelector('strong').textContent;

                if (this.querySelector('.fa-edit')) {
                    alert(`Edit user: ${userName}\nAnda harus menghubungkan ini ke form/modal edit.`);
                } else if (this.querySelector('.fa-key')) {
                    alert(`Reset password untuk: ${userName}\nAnda harus menghubungkan ini ke Controller.`);
                } else if (this.querySelector('.fa-user-slash') || this.querySelector('.fa-user-check')) {
                    alert(`Mengganti status untuk: ${userName}\nAnda harus menghubungkan ini ke Controller.`);
                } else if (this.querySelector('.fa-trash')) {
                    if (confirm(`Hapus user ${userName}?`)) {
                        alert(`Hapus user: ${userName}\nAnda harus menghubungkan ini ke Controller method DELETE/DESTROY.`);
                    }
                }
            });
        });

        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function (e) {
                if (!e.target.closest('.btn')) {
                    const userName = this.querySelector('strong').textContent;
                    console.log(`View user details: ${userName}`);
                }
            });
        });

    });
</script>
@endsection