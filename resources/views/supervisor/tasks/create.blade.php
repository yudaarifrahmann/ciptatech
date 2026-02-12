@extends('layouts.app')

@section('title', 'Tambah Tugas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="fas fa-tasks me-2 text-primary"></i>
                        Buat Tugas Baru
                    </h2>
                    <p class="text-muted mb-0">Divisi: <strong>{{ $division->name }}</strong></p>
                </div>
                
                <div class="bg-white p-3 rounded shadow-sm border" style="min-width: 250px;">
                    <label for="deadline" class="form-label fw-bold small mb-1">
                        <i class="fas fa-calendar-alt me-1 text-primary"></i> Tenggat Waktu
                    </label>
                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                           id="deadline" name="deadline" form="task-form" value="{{ old('deadline') }}">
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <form id="task-form" action="{{ route('supervisor.tasks.store') }}" method="POST">
                @csrf

                @if ($errors->any() && !$errors->has('deadline'))
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="task-items-container">
                    </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pb-5">
                    <button type="button" class="btn btn-outline-primary fw-bold" id="add-task-btn">
                        <i class="fas fa-plus-circle me-2"></i>TAMBAH TUGAS
                    </button>

                    <div class="d-flex gap-2">
                        <a href="{{ route('supervisor.tasks.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i>SIMPAN TUGAS
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .task-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-left: 5px solid #0d6efd;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        position: relative;
        transition: all 0.3s ease;
    }

    .task-card:hover {
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    .task-label {
        font-weight: 800;
        font-size: 0.9rem;
        color: #495057;
        letter-spacing: 0.5px;
    }

    .desc-label {
        font-weight: 700;
        font-size: 0.75rem;
        color: #adb5bd;
    }

    .remove-task {
        position: absolute;
        top: -10px;
        right: -10px;
        background: white;
        color: #dc3545;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border: 1px solid #f8d7da;
        transition: all 0.2s;
        z-index: 10;
    }

    .remove-task:hover {
        background: #dc3545;
        color: white;
        transform: scale(1.1);
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }
</style>

<script>
    let taskCount = 0;

    function addTaskItem() {
        taskCount++;
        const container = document.getElementById('task-items-container');
        const index = taskCount - 1;
        
        const taskHtml = `
            <div class="task-card shadow-sm">
                <div class="remove-task" onclick="removeTaskItem(this)" title="Hapus Tugas">
                    <i class="fas fa-times"></i>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="task-label mb-2 text-uppercase">TUGAS <span class="task-num">${taskCount}</span></label>
                        <input type="text" 
                               name="tasks[${index}][title]" 
                               class="form-control form-control-lg fs-6 border-2" 
                               placeholder="Apa yang perlu dikerjakan?" 
                               required>
                    </div>
                    <div class="col-12">
                        <label class="desc-label mb-1 text-uppercase text-muted">Deskripsi (Opsional)</label>
                        <textarea name="tasks[${index}][description]" 
                                  class="form-control bg-light" 
                                  rows="2" 
                                  placeholder="Tambahkan detail atau instruksi khusus untuk tugas ini..."></textarea>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', taskHtml);
        updateTaskNumbers();
    }

    function removeTaskItem(element) {
        const cards = document.querySelectorAll('.task-card');
        if (cards.length > 1) {
            element.closest('.task-card').remove();
            updateTaskNumbers();
        } else {
            alert("Minimal harus ada satu tugas yang dibuat.");
        }
    }

    function updateTaskNumbers() {
        const cards = document.querySelectorAll('.task-card');
        cards.forEach((card, i) => {
            // Update Numbering Text
            card.querySelector('.task-num').textContent = i + 1;
            
            // Update Input Names
            const inputs = card.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/tasks\[\d+\]/, `tasks[${i}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    document.getElementById('add-task-btn').addEventListener('click', addTaskItem);

    // Load first item on start
    document.addEventListener('DOMContentLoaded', function() {
        addTaskItem();
    });
</script>
@endsection