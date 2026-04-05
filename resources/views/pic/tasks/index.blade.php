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
                    Daftar Tugas Saya
                </h2>
                <p class="text-muted mb-0">Centang item tugas yang telah selesai dikerjakan</p>
                <small class="text-muted">
                    <i class="fas fa-users me-1"></i>
                    Divisi: {{ auth()->user()->division->name ?? 'Tidak ditentukan' }}
                </small>
            </div>

            @if($tasks->isEmpty())
                <!-- Empty State -->
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-inbox fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Tugas</h5>
                        <p class="text-muted mb-0">Anda belum memiliki tugas yang harus dikerjakan. Tugas akan muncul di sini ketika supervisor menambahkan tugas untuk divisi Anda.</p>
                    </div>
                </div>
            @else
                <div class="list-group shadow-sm">
                    @foreach ($tasks as $index => $task)
                        @php
                            // Ambil child tasks berdasarkan task_group_id
                            $childTasks = \App\Models\Task::where('task_group_id', $task->id)->get();
                            
                            // Ambil submission untuk task ini
                            $submission = \App\Models\TaskSubmission::where('task_id', $task->id)
                                ->where('pic_id', auth()->id())
                                ->first();
                            
                            // Hitung tugas yang sudah selesai untuk PIC ini
                            $completedCount = 0;
                            if ($submission) {
                                $completedCount = \DB::table('completed_tasks')
                                    ->where('task_submission_id', $submission->id)
                                    ->whereIn('task_id', $childTasks->pluck('id')->toArray())
                                    ->count();
                            }
                        @endphp

                        <div class="list-group-item p-0 mb-3 border rounded overflow-hidden">
                            <!-- Header Group - Clickable for toggle -->
                            <button class="d-flex justify-content-between align-items-center p-3 bg-light w-100 border-0 toggle-header"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#taskContent{{ $index }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="taskContent{{ $index }}">
                                <div class="text-start">
                                    <h5 class="fw-bold mb-1">
                                        <i class="fas fa-folder-open text-primary me-2"></i>
                                        {{ $task->title }}
                                    </h5>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Deadline: 
                                        @if ($task->deadline)
                                            <strong>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</strong>
                                        @else
                                            <strong>Tidak ditentukan</strong>
                                        @endif
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-list-check me-1"></i>
                                        {{ $childTasks->count() }} item tugas
                                    </small>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <!-- Status Badge -->
                                    @if ($submission)
                                        @if ($submission->status === 'pending')
                                            <span class="badge bg-warning me-3">Pending</span>
                                        @elseif ($submission->status === 'completed')
                                            <span class="badge bg-success me-3">Selesai</span>
                                        @elseif ($submission->status === 'submitted')
                                            <span class="badge bg-info me-3">Diserahkan</span>
                                        @elseif ($submission->status === 'approved')
                                            <span class="badge bg-success me-3">Disetujui</span>
                                        @elseif ($submission->status === 'rejected')
                                            <span class="badge bg-danger me-3">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary me-3">Belum Dikerjakan</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary me-3">Belum Dikerjakan</span>
                                    @endif
                                    
                                    <!-- Progress Badge -->
                                    <span class="badge bg-primary me-2">
                                        {{ $completedCount }}/{{ $childTasks->count() }} Selesai
                                    </span>
                                    
                                    <!-- Detail Link -->
                                    <a href="{{ route('pic.tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary ms-2 me-2" onclick="event.stopPropagation();">
                                        <i class="fas fa-eye"></i> Detail & Submit
                                    </a>

                                    <!-- Toggle Icon -->
                                    <i class="fas fa-chevron-down toggle-icon ms-2 transition-icon"></i>
                                </div>

                            </button>

                            <!-- Task Items - Collapsible Content -->
                            <div class="collapse {{ $index === 0 ? 'show' : '' }} task-content" id="taskContent{{ $index }}">
                                <div class="p-3 pt-0">
                                    <!-- Task Description -->
                                    @if($task->description)
                                        <div class="alert alert-light mb-3">
                                            <strong><i class="fas fa-align-left me-1"></i>Deskripsi Tugas:</strong>
                                            <p class="mb-0 mt-1">{{ $task->description }}</p>
                                        </div>
                                    @endif

                                    @foreach ($childTasks as $childIndex => $childTask)
                                        @php
                                            // Cek apakah tugas ini sudah diselesaikan oleh user
                                            $isCompleted = false;
                                            if ($submission) {
                                                $isCompleted = \DB::table('completed_tasks')
                                                    ->where('task_submission_id', $submission->id)
                                                    ->where('task_id', $childTask->id)
                                                    ->exists();
                                            }
                                        @endphp

                                        <div class="d-flex align-items-center mb-2 task-item {{ $isCompleted ? 'task-completed' : '' }}"
                                             style="padding: 12px; border-radius: 8px; background-color: {{ $isCompleted ? '#e8f5e9' : 'transparent' }};">
                                            
                                            <!-- Checkbox on the left -->
                                            <div class="me-3">
                                                <input class="form-check-input task-checkbox"
                                                    type="checkbox"
                                                    id="task_{{ $childTask->id }}"
                                                    data-task-id="{{ $childTask->id }}"
                                                    data-task-title="{{ $childTask->task_item_title }}"
                                                    data-main-task-id="{{ $task->id }}"
                                                    {{ $isCompleted ? 'checked disabled' : '' }}
                                                    style="width: 20px; height: 20px; cursor: {{ $isCompleted ? 'not-allowed' : 'pointer' }};">
                                            </div>
                                            
                                            <!-- Task title -->
                                            <div class="flex-grow-1">
                                                <label class="form-check-label {{ $isCompleted ? 'text-decoration-line-through text-muted' : 'fw-medium' }}"
                                                       for="task_{{ $childTask->id }}"
                                                       style="cursor: {{ $isCompleted ? 'default' : 'pointer' }}">
                                                    {{ $childIndex + 1 }}. {{ $childTask->task_item_title }}
                                                </label>
                                                
                                                @if($childTask->description)
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        {{ $childTask->description }}
                                                    </small>
                                                @endif
                                            </div>
                                            
                                            <!-- Status badge -->
                                            <span class="badge {{ $isCompleted ? 'bg-success' : 'bg-secondary' }} ms-2">
                                                {{ $isCompleted ? 'Selesai' : 'Belum' }}
                                            </span>
                                        </div>
                                    @endforeach

                                    <!-- Feedback from Supervisor -->
                                    @if ($submission && $submission->feedback)
                                        <div class="alert alert-info mt-3 mb-0">
                                            <strong><i class="fas fa-comment-dots me-1"></i>Catatan Supervisor:</strong>
                                            <p class="mb-0 mt-1">{{ $submission->feedback }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                @csrf
                <input type="hidden" id="modalTaskId" name="task_id">
                <input type="hidden" id="modalMainTaskId" name="main_task_id">
                
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
                    
                    <!-- GitHub Link Input (Only for Software Host/Division 3) -->
                    @if(auth()->user()->division_id == 3)
                    <div class="mb-3">
                        <label for="githubLink" class="form-label fw-bold">
                            <i class="fab fa-github me-1 text-dark"></i>Link Repository GitHub
                            <span class="badge bg-info ms-2">Software Host</span>
                            <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input type="url" class="form-control" id="githubLink" name="github_link" 
                               placeholder="https://github.com/username/repository"
                               pattern="https://.*github\.com/.*">
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>
                            Sertakan link repository GitHub jika ada kode yang di-push
                        </small>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i>Ya, Tandai Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.task-item {
    transition: all 0.2s ease;
    border: 1px solid #e0e0e0;
}

.task-item:hover {
    background-color: #f8f9fa !important;
    border-color: #c5c5c5;
}

.task-completed {
    background-color: #e8f5e9 !important;
}

.task-completed label {
    text-decoration: line-through;
    color: #6c757d;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.form-check-input:not(:disabled):not(:checked):hover {
    border-color: #198754;
}

.badge {
    font-size: 0.85em;
    padding: 5px 10px;
}

.toggle-header {
    cursor: pointer;
    transition: all 0.2s ease;
}

.toggle-header:hover {
    background-color: #e9ecef !important;
}

.toggle-header[aria-expanded="true"] .toggle-icon {
    transform: rotate(180deg);
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.task-content {
    transition: all 0.3s ease;
}

.list-group-item {
    border-radius: 10px !important;
}

/* Animation for expanding/collapsing */
.collapsing {
    transition: height 0.3s ease;
}

/* Make sure the header has proper cursor */
.toggle-header h5 {
    cursor: pointer;
}

/* Progress indicator */
.progress-bar {
    transition: width 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    const completionForm = document.getElementById('completionForm');
    let currentTaskId = null;
    let currentMainTaskId = null;
    
    // Attach event listeners to checkboxes
    document.querySelectorAll('.task-checkbox:not(:disabled)').forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            if (this.checked) {
                const taskId = this.dataset.taskId;
                const taskTitle = this.dataset.taskTitle;
                const mainTaskId = this.dataset.mainTaskId;
                
                // Store the task ID for later use
                currentTaskId = taskId;
                currentMainTaskId = mainTaskId;
                
                // Set modal data
                document.getElementById('modalTaskId').value = taskId;
                document.getElementById('modalMainTaskId').value = mainTaskId;
                document.getElementById('taskNameDisplay').textContent = `"${taskTitle}"`;
                
                // Reset form
                completionForm.reset();
                
                // Show modal
                confirmationModal.show();
                
                // Uncheck the checkbox (will be checked after successful submission)
                this.checked = false;
            }
        });
    });
    
    // Handle form submission
    completionForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
        submitBtn.disabled = true;
        
        try {
            const formData = new FormData(this);
            
            // Get CSRF token safely
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : document.querySelector('input[name="_token"]')?.value;
            
            if (!csrfToken) {
                showToast('Kesalahan: Token keamanan tidak ditemukan', 'error');
                return;
            }
            
            const response = await fetch(`/pic/tasks/${currentTaskId}/complete`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            
            if (!response.ok) {
                const errorData = await response.json();
                showToast(errorData.message || `Kesalahan: ${response.status}`, 'error');
                return;
            }
            
            const data = await response.json();
            
            if (data.success) {
                // Update UI
                const checkbox = document.getElementById(`task_${data.task_id}`);
                const taskItem = checkbox.closest('.task-item');
                const label = taskItem.querySelector('label');
                const badge = taskItem.querySelector('.badge');
                
                // Update checkbox
                checkbox.checked = true;
                checkbox.disabled = true;
                
                // Update task item styling
                taskItem.classList.add('task-completed');
                taskItem.style.backgroundColor = '#e8f5e9';
                label.classList.add('text-decoration-line-through', 'text-muted');
                label.classList.remove('fw-medium');
                
                // Update badge
                badge.classList.remove('bg-secondary');
                badge.classList.add('bg-success');
                badge.textContent = 'Selesai';
                
                // Update progress counter for this main task
                const mainTaskItem = checkbox.closest('.list-group-item');
                const progressBadge = mainTaskItem.querySelector('.bg-primary');
                const currentCount = parseInt(progressBadge.textContent.split('/')[0]);
                const totalCount = parseInt(progressBadge.textContent.split('/')[1].split(' ')[0]);
                progressBadge.textContent = `${currentCount + 1}/${totalCount} Selesai`;
                
                // Show success message
                showToast('Tugas berhasil ditandai selesai!', 'success');
                
                // Close modal
                confirmationModal.hide();
            } else {
                showToast(data.message || 'Gagal menandai tugas selesai', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat memproses permintaan: ' + error.message, 'error');
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });
    
    // Add click animation to toggle headers
    document.querySelectorAll('.toggle-header').forEach(header => {
        header.addEventListener('click', function() {
            const icon = this.querySelector('.toggle-icon');
            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            
            if (target.classList.contains('show')) {
                // Will collapse
                icon.style.transform = 'rotate(0deg)';
            } else {
                // Will expand
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
    
    // Auto-open the first item
    const firstToggle = document.querySelector('.toggle-header');
    if (firstToggle) {
        firstToggle.click();
    }
    
    function showToast(message, type) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Add to body
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
});
</script>
@endsection