@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold mb-2">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    Daftar Tugas
                </h2>
                <p class="text-muted mb-0">Centang item tugas yang telah selesai dikerjakan</p>
            </div>

            @if ($submissions->count() > 0)
                @foreach ($submissions as $submission)
                    <div class="card shadow-sm border-0 mb-4">
                        <!-- Task Group Header -->
                        <div class="card-header bg-gradient-primary py-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2 text-dark">
                                        <i class="fas fa-briefcase me-2"></i>
                                        {{ $submission->task->title }}
                                    </h5>
                                    <div class="text-muted small">
                                        <p class="mb-1">
                                            <i class="fas fa-user me-1"></i>
                                            Dari: <strong>{{ $submission->task->supervisor->name }}</strong>
                                        </p>
                                        @if ($submission->task->description)
                                            <p class="mb-0">
                                                <i class="fas fa-align-left me-1"></i>
                                                {{ $submission->task->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    @php
                                        $childTasks = \App\Models\Task::where('task_group_id', $submission->task->id)->get();
                                        $progress = $childTasks->count() > 0 ? round(($submission->completed_tasks_count / $childTasks->count()) * 100) : 0;
                                    @endphp
                                    <span class="badge bg-primary">{{ $submission->completed_tasks_count }}/{{ $childTasks->count() }} Selesai</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="card-body pt-3">
                            @if ($childTasks->count() > 0)
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Progress Penyelesaian</small>
                                        <small class="fw-bold">{{ $progress }}%</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                             role="progressbar" 
                                             style="width: {{ $progress }}%"
                                             aria-valuenow="{{ $progress }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Task Items List -->
                            <div class="task-items-list">
                                @foreach ($childTasks as $task)
                                    @php
                                        $isCompleted = $submission->completed_tasks_count > 0 && 
                                                      \DB::table('completed_tasks')->where([
                                                          'task_submission_id' => $submission->id,
                                                          'task_id' => $task->id
                                                      ])->exists();
                                    @endphp
                                    <div class="task-item {{ $isCompleted ? 'completed' : '' }}" data-task-id="{{ $task->id }}" data-submission-id="{{ $submission->id }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input task-checkbox" 
                                                       type="checkbox" 
                                                       id="task_{{ $task->id }}"
                                                       data-task-id="{{ $task->id }}"
                                                       data-task-title="{{ $task->task_item_title }}"
                                                       {{ $isCompleted ? 'checked' : '' }}
                                                       {{ ($submission->status === 'approved' || $submission->status === 'completed') ? 'disabled' : '' }}>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-check-label mb-0" for="task_{{ $task->id }}">
                                                    <strong>{{ $task->task_item_title }}</strong>
                                                </label>
                                            </div>
                                            <div class="text-end">
                                                @if ($isCompleted)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Deadline -->
                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Deadline: <strong>
                                                @if ($submission->task->deadline)
                                                    {{ \Carbon\Carbon::parse($submission->task->deadline)->format('d M Y') }}
                                                @else
                                                    Tidak ditentukan
                                                @endif
                                            </strong>
                                        </small>
                                    </div>
                                    <div>
                                        @if ($submission->status === 'pending')
                                            <span class="badge bg-warning">Status: Pending</span>
                                        @elseif ($submission->status === 'completed')
                                            <span class="badge bg-info">Status: Diserahkan</span>
                                        @elseif ($submission->status === 'approved')
                                            <span class="badge bg-success">Status: Disetujui</span>
                                        @elseif ($submission->status === 'rejected')
                                            <span class="badge bg-danger">Status: Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($submission->feedback)
                                <div class="alert alert-info mt-3 mb-0">
                                    <strong>Catatan Supervisor:</strong>
                                    <p class="mb-0">{{ $submission->feedback }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-inbox fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Tugas</h5>
                        <p class="text-muted mb-0">Anda belum menerima tugas apapun dari supervisor. Tugas akan muncul di sini ketika supervisor menambahkan tugas untuk Anda.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Confirmation Modal with File Upload -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-question-circle text-primary me-2"></i>
                    Konfirmasi Penyelesaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="completionForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <p id="confirmationMessage" class="mb-3">
                        Apakah Anda yakin ingin menandai tugas <strong id="taskNameDisplay"></strong> sebagai <strong>selesai</strong>?
                    </p>
                    
                    <div class="mb-3">
                        <label for="evidenceFile" class="form-label fw-bold">
                            <i class="fas fa-file-upload me-1"></i>Upload Bukti Penyelesaian (Opsional)
                        </label>
                        <input type="file" class="form-control" id="evidenceFile" name="evidence" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx">
                        <small class="text-muted">Maksimal 10MB. Format: PDF, Word, Excel, atau Gambar</small>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-1"></i>Catatan Penyelesaian (Opsional)
                        </label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tuliskan catatan tentang penyelesaian tugas..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmBtn">
                        <i class="fas fa-check me-1"></i>Ya, Tandai Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .task-items-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .task-item {
        padding: 12px 16px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .task-item:hover {
        background: #f0f1f3;
        border-color: #0d6efd;
    }

    .task-item.completed {
        background: #e8f5e9;
        border-color: #4caf50;
    }

    .task-item.completed .form-check-label {
        color: #999;
        text-decoration: line-through;
    }

    .task-checkbox {
        cursor: pointer;
        width: 20px;
        height: 20px;
    }

    .task-checkbox:checked {
        background-color: #4caf50;
        border-color: #4caf50;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a5ae8 100%);
        color: white;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
        font-size: 12px;
    }

    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
    }

    .form-check-label {
        cursor: pointer;
        font-size: 15px;
    }
</style>

<script>
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    let selectedTaskId = null;

    // Attach event listeners to all checkboxes
    function attachCheckboxListeners() {
        document.querySelectorAll('.task-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                if (this.checked) {
                    selectedTaskId = this.dataset.taskId;
                    const taskTitle = this.dataset.taskTitle;
                    
                    // Update modal with task name
                    document.getElementById('taskNameDisplay').textContent = `"${taskTitle}"`;
                    
                    // Clear form
                    document.getElementById('completionForm').reset();
                    
                    confirmationModal.show();
                    this.checked = false; // Reset checkbox sampai dikonfirmasi
                }
            });
        });
    }

    // Initial attach
    document.addEventListener('DOMContentLoaded', function() {
        attachCheckboxListeners();
    });

    document.getElementById('confirmBtn').addEventListener('click', async function() {
        try {
            const formData = new FormData();
            const evidenceFile = document.getElementById('evidenceFile').files[0];
            const notes = document.getElementById('notes').value;
            
            if (evidenceFile) {
                formData.append('evidence', evidenceFile);
            }
            if (notes) {
                formData.append('notes', notes);
            }

            const response = await fetch(`/pic/tasks/${selectedTaskId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                // Update UI - find checkbox by id
                const checkbox = document.getElementById(`task_${selectedTaskId}`);
                if (checkbox) {
                    checkbox.checked = true;
                    checkbox.closest('.task-item').classList.add('completed');
                }

                // Update progress bar and badge
                const card = checkbox.closest('.card');
                const progressBar = card.querySelector('.progress-bar');
                const badge = card.querySelector('.badge');
                
                if (progressBar) {
                    const newProgress = (data.completed_count / data.total_count) * 100;
                    progressBar.style.width = newProgress + '%';
                    const progressText = progressBar.parentElement.querySelector('small:last-child');
                    if (progressText) {
                        progressText.textContent = Math.round(newProgress) + '%';
                    }
                }
                
                if (badge) {
                    badge.textContent = `${data.completed_count}/${data.total_count} Selesai`;
                }

                // Show success toast
                showToast('Tugas berhasil ditandai selesai!', 'success');
                
                confirmationModal.hide();
            } else {
                showToast(data.message || 'Gagal menandai tugas selesai', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat memproses permintaan', 'error');
        }
    });

    function showToast(message, type) {
        const toastContainer = document.body;
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed bottom-0 end-0 m-3`;
        toast.innerHTML = message;
        toast.style.zIndex = '9999';
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>
@endsection
