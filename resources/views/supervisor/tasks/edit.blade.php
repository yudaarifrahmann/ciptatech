@extends('layouts.app')

@section('title', 'Edit Tugas - ' . $task->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold mb-2">
                    <i class="fas fa-edit me-2 text-primary"></i>
                    Edit Tugas
                </h2>
                <p class="text-muted mb-0">Perbarui detail tugas: <strong>{{ $task->title }}</strong></p>
            </div>

            <!-- Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ada kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('supervisor.tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading me-2"></i>Judul Tugas
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" placeholder="Masukkan judul tugas"
                                   value="{{ old('title', $task->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2"></i>Deskripsi Tugas
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6"
                                      placeholder="Jelaskan detail tugas">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-4">
                            <label for="deadline" class="form-label fw-bold">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal Deadline
                            </label>
                            <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                   id="deadline" name="deadline" value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}">
                            @error('deadline')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Info -->
                        <div class="alert alert-info border-0" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Status Tugas:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('supervisor.tasks.show', $task) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
