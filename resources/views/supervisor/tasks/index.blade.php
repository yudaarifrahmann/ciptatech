@extends('layouts.app')

@section('title', 'Kelola Tugas')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-tasks me-2 text-primary"></i>
                Kelola Tugas
            </h2>
            <p class="text-muted mb-0">Buat dan kelola tugas untuk tim divisi Anda</p>
        </div>
        <a href="{{ route('supervisor.tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Tugas
        </a>
    </div>

    <!-- Alerts -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tasks List -->
    <div class="row">
        @forelse($tasks as $task)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title fw-bold mb-1">{{ $task->title }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-building me-1"></i>
                                    {{ $task->division->name }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'submitted' ? 'warning' : 'info') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">{{ Str::limit($task->description, 100) }}</p>
                        
                        @if ($task->deadline)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Deadline: <strong>{{ $task->deadline->format('d M Y') }}</strong>
                                </small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Progress Submission:</small>
                            @php
                                $submissions = $task->submissions;
                                $approved = $submissions->where('status', 'approved')->count();
                                $total = $submissions->count();
                                $percentage = $total > 0 ? ($approved / $total) * 100 : 0;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $percentage }}%" 
                                     aria-valuenow="{{ $approved }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $total }}">
                                    {{ $approved }}/{{ $total }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top py-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('supervisor.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            <a href="{{ route('supervisor.tasks.review', $task) }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-check me-1"></i>Review
                            </a>
                            <div class="dropdown ms-auto">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('supervisor.tasks.edit', $task) }}">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('supervisor.tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin?')">
                                                <i class="fas fa-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3 d-block text-primary"></i>
                    <h5 class="mb-2">Belum Ada Tugas</h5>
                    <p class="text-muted mb-0">Mulai buat tugas untuk tim divisi Anda</p>
                    <a href="{{ route('supervisor.tasks.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Buat Tugas Pertama
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->links() }}
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection
