@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0"><i class="fa-solid fa-building me-2"></i>Manajemen Divisi</h4>
            <p class="text-muted small">Kelola semua divisi dalam sistem</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
            <i class="fas fa-plus me-2"></i>Tambah Divisi
        </button>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading mb-2">Error!</h6>
            @foreach ($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Divisions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-bold"><i class="fas fa-table me-2"></i>Daftar Divisi</h6>
        </div>
        <div class="card-body">
            @if ($divisions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No.</th>
                                <th>Nama Divisi</th>
                                <th>Deskripsi</th>
                                <th style="width: 120px;">Status</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($divisions as $index => $division)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-building text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $division->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $division->description ?? '-' }}</small>
                                </td>
                                <td>
                                    @if ($division->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="fas fa-pause-circle me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editDivisionModal"
                                                onclick="editDivision({{ $division->id }}, '{{ $division->name }}', '{{ $division->description }}', {{ $division->is_active ? 'true' : 'false' }})">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <form method="POST" action="{{ route('superadmin.divisions.destroy', $division->id) }}" 
                                              class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada divisi yang tersedia</p>
                    <small class="text-muted">Klik tombol "Tambah Divisi" untuk membuat divisi baru</small>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah Divisi -->
<div class="modal fade" id="createDivisionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <h6 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Tambah Divisi Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('superadmin.divisions.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Divisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" placeholder="Masukkan nama divisi" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="3" placeholder="Masukkan deskripsi divisi (opsional)"></textarea>
                    </div>
                    <div class="mb-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Aktifkan divisi
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Divisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Divisi -->
<div class="modal fade" id="editDivisionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info bg-opacity-10 border-0">
                <h6 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Divisi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label fw-bold">Nama Divisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editIsActive" 
                                   name="is_active" value="1">
                            <label class="form-check-label" for="editIsActive">
                                Aktifkan divisi
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.02);
    }
    
    .btn-group-sm .btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
    }
</style>

<script>
    function editDivision(id, name, description, isActive) {
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description || '';
        document.getElementById('editIsActive').checked = isActive;
        document.getElementById('editForm').action = `/superadmin/divisions/${id}`;
    }
</script>

@endsection
