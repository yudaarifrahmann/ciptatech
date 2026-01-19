@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold mb-2">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>
                    Tambah Tugas Grup
                </h2>
                <p class="text-muted mb-0">Buat tugas dengan multiple items untuk divisi: <strong>{{ $division->name }}</strong></p>
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

                    <form action="{{ route('supervisor.tasks.store') }}" method="POST">
                        @csrf

                        <!-- Main Title -->
                        <div class="mb-4">
                            <label for="main_title" class="form-label fw-bold">
                                <i class="fas fa-heading me-2"></i>Judul Tugas Utama
                            </label>
                            <input type="text" class="form-control @error('main_title') is-invalid @enderror" 
                                   id="main_title" name="main_title" placeholder="Contoh: Desain Material Marketing Q1 2026"
                                   value="{{ old('main_title') }}" required>
                            @error('main_title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Judul umum untuk group tugas ini</small>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2"></i>Deskripsi Tugas
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4"
                                      placeholder="Jelaskan konteks dan detail umum dari tugas">{{ old('description') }}</textarea>
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
                                   id="deadline" name="deadline" value="{{ old('deadline') }}">
                            @error('deadline')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Items -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-list-ul me-2"></i>Item-Item Tugas
                            </label>
                            <div id="task-items-container">
                                <!-- Task items akan ditambah di sini -->
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="add-task-btn">
                                <i class="fas fa-plus me-2"></i>Tambah Item Tugas
                            </button>
                        </div>

                        <!-- Info -->
                        <div class="alert alert-info border-0" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Anda bisa menambah multiple item tugas dalam satu form. 
                            PIC akan melihat semua item dalam bentuk checkbox list.
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Buat Tugas Grup
                            </button>
                            <a href="{{ route('supervisor.tasks.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Assigned PICs Info -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-users me-2"></i>
                        PIC yang akan menerima tugas ini
                    </h6>
                </div>
                <div class="card-body">
                    @if ($pics->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($pics as $pic)
                                <div class="list-group-item px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $pic->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $pic->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Belum ada PIC di divisi {{ $division->name }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        color: #333;
        margin-bottom: 0.75rem;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .task-item {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 12px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .task-item-input {
        flex: 1;
    }

    .task-item-input input {
        width: 100%;
    }

    .task-item-remove {
        flex-shrink: 0;
        margin-top: 6px;
    }

    .task-item-number {
        background: #0d6efd;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        flex-shrink: 0;
    }
</style>

<script>
    let taskCount = 0;

    function addTaskItem() {
        taskCount++;
        const container = document.getElementById('task-items-container');
        
        const taskItem = document.createElement('div');
        taskItem.className = 'task-item';
        taskItem.innerHTML = `
            <div class="task-item-number">${taskCount}</div>
            <div class="task-item-input">
                <input type="text" 
                       name="tasks[${taskCount - 1}][title]" 
                       class="form-control form-control-sm"
                       placeholder="Deskripsi item tugas"
                       required>
            </div>
            <div class="task-item-remove">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTaskItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(taskItem);
        updateTaskNumbers();
    }

    function removeTaskItem(btn) {
        btn.closest('.task-item').remove();
        updateTaskNumbers();
    }

    function updateTaskNumbers() {
        const items = document.querySelectorAll('.task-item');
        items.forEach((item, index) => {
            item.querySelector('.task-item-number').textContent = index + 1;
        });
    }

    document.getElementById('add-task-btn').addEventListener('click', addTaskItem);

    // Add first task item on load
    document.addEventListener('DOMContentLoaded', function() {
        addTaskItem();
    });
</script>
@endsection
