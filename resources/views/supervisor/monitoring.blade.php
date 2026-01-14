@extends('layouts.app')

@section('title', 'Monitoring Divisi')

@section('content')
<div class="monitoring-wrapper py-3">
    <!-- Header Section -->
    <div class="monitoring-header mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div class="header-content">
                <div class="d-flex align-items-center mb-3">
                    <div class="header-icon me-3">
                        <div class="icon-wrapper bg-gradient-primary p-3 rounded-circle">
                            <i class="fas fa-diagram-project fa-2x text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Monitoring Tugas</h4>
                        <p class="text-muted mb-0">Pantau progress tugas secara real-time</p>
                    </div>
                </div>
            </div>
            
            <div class="header-actions mt-3 mt-md-0">
                <div class="d-flex flex-wrap gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chart-simple me-1"></i>Tampilkan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Tugas</a></li>
                            <li><a class="dropdown-item" href="#">Aktif Saja</a></li>
                            <li><a class="dropdown-item" href="#">Selesai</a></li>
                            <li><a class="dropdown-item" href="#">Menunggu Review</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Tugas</h6>
                    <h2 class="fw-bold mb-0">{{ $totalTasks }}</h2>
                    <small class="text-muted">Aktif: {{ $tasks->where('status','!=','Tuntas')->count() }}</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tasks fa-2x text-primary opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Menunggu Review</h6>
                    <h2 class="fw-bold mb-0">{{ $waitingReview }}</h2>
                    <small class="text-warning">
                        <i class="fas fa-clock me-1"></i>Perlu ditinjau
                    </small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-clock-rotate-left fa-2x text-warning opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Tuntas</h6>
                    <h2 class="fw-bold mb-0">{{ $completed }}</h2>
                    <small class="text-success">
                        <i class="fas fa-check-circle me-1"></i>On schedule
                    </small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-double fa-2x text-success opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-white rounded-3 p-3 shadow-sm border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Progress Rata-rata</h6>
                    <h2 class="fw-bold mb-0">{{ round($averageProgress) }}%</h2>
                    <small class="text-info">
                        <i class="fas fa-chart-line me-1"></i>Rata-rata progress
                    </small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-percent fa-2x text-info opacity-75"></i>
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
                        Daftar Tugas
                    </h5>
                    <p class="text-muted small mb-0">Detail tugas dengan status terkini</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 shadow-none" placeholder="Cari tugas...">
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
                            <th class="ps-4">
                                <div class="d-flex align-items-center">
                                    <span>Divisi</span>
                                    <button class="btn btn-link btn-sm p-0 ms-1">
                                        <i class="fas fa-sort text-muted"></i>
                                    </button>
                                </div>
                            </th>
                            <th>Nama Tugas</th>
                            <th>PIC</th>
                            <th>Progress</th>
                            <th>Status Laporan</th>
                            <th class="text-end pe-4">Monitoring</th>
                        </tr>
                    </thead>
                    <tbody>
@foreach ($tasks as $task)
<tr>
    {{-- Divisi --}}
    <td>
        {{ $task->pic->division->name ?? '-' }}
    </td>

    {{-- Nama Tugas --}}
    <td>
        <strong>{{ $task->task_name }}</strong><br>
        <small class="text-muted">
            Deadline: {{ $task->deadline ? $task->deadline->format('d M Y') : '-' }}
        </small>
    </td>

    {{-- PIC --}}
    <td>
        {{ $task->pic->name ?? '-' }}
    </td>

    {{-- Progress --}}
    <td>
        <div class="progress" style="height: 6px;">
            <div class="progress-bar"
                style="width: {{ $task->progress }}%">
            </div>
        </div>
        <small>{{ $task->progress }}%</small>
    </td>

    {{-- Status --}}
    <td>
        <span class="badge bg-info">
            {{ ucfirst($task->status) }}
        </span>
    </td>

    {{-- Monitoring --}}
    <td>
        <button type="button"
        class="btn btn-sm btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#detailTaskModal{{ $task->id }}">
    <i class="fas fa-eye"></i>
</button>

       <button type="button" 
        class="btn btn-sm btn-warning" 
        data-bs-toggle="modal" 
        data-bs-target="#modalKomentar{{ $task->id }}">
    <i class="fas fa-comment"></i>
</button>
    </td>
</tr>

<!-- Modal Komentar -->
<div class="modal fade" id="modalKomentar{{ $task->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Beri Komentar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('supervisor.monitoring.comment', $task->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Isi Komentar</label>
                        <textarea class="form-control" name="comment" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Komentar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Tugas -->
<div class="modal fade" id="detailTaskModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    {{ $task->task_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <strong>Divisi:</strong>
                            {{ $task->pic->division->name ?? '-' }}
                        </div>

                        <div class="mb-2">
                            <strong>PIC:</strong>
                            {{ $task->pic->name ?? '-' }}
                        </div>

                        <div class="mb-2">
                            <strong>Progress:</strong>
                            {{ $task->progress }}%
                        </div>

                        <div class="mb-2">
                            <strong>Status:</strong>
                            <span class="badge bg-{{ $task->status == 'Tuntas' ? 'success' : ($task->status == 'menunggu review' ? 'info' : 'warning') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 border-start">
                        <h6 class="fw-bold">File Pendukung</h6>
                        @if ($task->file_path)
                            @php
                                $extension = pathinfo($task->file_path, PATHINFO_EXTENSION);
                                $mediaUrl = asset('storage/' . $task->file_path); // Sesuaikan dengan disk storage Anda
                            @endphp
                            
                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                               <div class="ratio ratio-16x9 mb-2">
    <img src="{{ $mediaUrl }}" 
         class="img-fluid rounded img-preview-trigger" 
         alt="Bukti Tugas"
         onclick="showImagePreview('{{ $mediaUrl }}', '{{ $task->task_name }}')">
</div>
<div class="text-center">
    <button type="button" class="btn btn-link btn-sm text-decoration-none p-0" onclick="showImagePreview('{{ $mediaUrl }}', '{{ $task->task_name }}')">
        <i class="fas fa-search-plus me-1"></i> Perbesar Gambar
    </button>
</div>
<small class="text-muted mt-1 d-block">
    <i class="fas fa-search-plus me-1"></i>Klik gambar untuk memperbesar
</small>
                                <small class="text-muted mt-1 d-block">Tipe: Foto</small>
                            @elseif (in_array($extension, ['mp4', 'webm', 'ogg']))
                                <div class="ratio ratio-16x9">
                                    <video controls class="embed-responsive-item rounded">
                                        <source src="{{ $mediaUrl }}" type="video/{{ $extension }}">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                                <small class="text-muted mt-1 d-block">Tipe: Video</small>
                            @else
                                <p class="text-warning">
                                    <i class="fas fa-file me-1"></i>
                                    File tidak dapat ditampilkan ({{ strtoupper($extension) }}).
                                </p>
                                <a href="{{ $mediaUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-download me-1"></i> Unduh File
                                </a>
                            @endif
                        @else
                            <p class="text-muted fst-italic">Tidak ada file pendukung dilampirkan.</p>
                        @endif
                    </div>

                </div>

                <hr>

                <h6 class="fw-bold">Deskripsi Tugas</h6>
                <p class="text-muted">
                    {{ $task->description ?? 'Tidak ada deskripsi tugas.' }}
                </p>
            </div>

            <div class="modal-footer">
             @if (strtolower($task->status) == 'menunggu review')
                    
                    <button type="button" 
                            class="btn btn-warning btn-sm update-status-btn"
                            data-task-id="{{ $task->id }}"
                            data-new-status="progress"> 
                        <i class="fas fa-undo me-1"></i> Revisi
                    </button>

                    <button type="button" 
                            class="btn btn-success btn-sm update-status-btn"
                            data-task-id="{{ $task->id }}"
                            data-new-status="selesai"> 
                        <i class="fas fa-check me-1"></i> Tuntas
                    </button>
                
                @endif
                
                <button type="button"
                        class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
           
        </div>
    </div>
</div>

@endforeach
</tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer">
    {{ $tasks->links() }}
</div>
    </div>

        <!-- ==================== DAILY REPORTS SECTION ==================== -->
<div class="daily-reports-section mt-5">
    <div class="section-header mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="fas fa-chart-line text-info me-2"></i>
                    Daily Reports
                </h5>
                <p class="text-muted mb-0">Laporan harian dari PIC di divisi Anda</p>
            </div>
            <a href="{{ route('supervisor.daily-reports.index') }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-external-link-alt me-1"></i>Lihat Semua
            </a>
        </div>
    </div>

    @php
    // Ambil data daily reports dari PIC di divisi supervisor
    use App\Models\DailyReport;
    use App\Models\User;
    
    $supervisor = auth()->user();
    $picUsers = User::where('role', 'PIC')
        ->where('division_id', $supervisor->division_id)
        ->where('is_active', 1) // ✅ PERBAIKI: ganti 'status' dengan 'is_active'
        ->pluck('id');
    
    $dailyReports = DailyReport::with('user')
        ->whereIn('user_id', $picUsers)
        ->latest('report_date')
        ->latest('created_at')
        ->take(5) // Limit 5 terbaru
        ->get();
    
    $totalDailyReports = DailyReport::whereIn('user_id', $picUsers)->count();
    $todayReports = DailyReport::whereIn('user_id', $picUsers)
        ->whereDate('report_date', today())
        ->count();
@endphp

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Reports</h6>
                            <h2 class="fw-bold mb-0">{{ $totalDailyReports }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-file-alt fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Hari Ini</h6>
                            <h2 class="fw-bold mb-0">{{ $todayReports }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-calendar-day fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">PIC Aktif</h6>
                            <h2 class="fw-bold mb-0">
                                {{ User::where('role', 'PIC')
                                    ->where('division_id', $supervisor->division_id)
                                    ->where('is_active', 1)
                                    ->count() }}
                            </h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-users fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Reports Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-list me-2 text-info"></i>
                Daily Reports Terbaru
            </h5>
        </div>
        <div class="card-body p-0">
            @if($dailyReports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Tanggal</th>
                                <th>Nama PIC</th>
                                <th>Task</th>
                                <th>Divisi</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyReports as $report)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($report->report_date)->translatedFormat('d M Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $report->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($report->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $report->user->name }}</div>
                                                <small class="text-muted">{{ $report->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" 
                                             data-bs-toggle="tooltip" title="{{ $report->task }}">
                                            {{ $report->task }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                            {{ $report->user->division->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-outline-info btn-sm view-daily-detail"
                                                data-bs-toggle="modal"
                                                data-bs-target="#dailyDetailModal"
                                                data-report='@json($report)'
                                                data-user='@json($report->user)'>
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <h5>Belum ada daily report</h5>
                        <p>PIC di divisi Anda belum membuat laporan harian</p>
                        <a href="{{ route('supervisor.users.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user-plus me-1"></i>Kelola PIC
                        </a>
                    </div>
                </div>
            @endif
        </div>
        
        @if($totalDailyReports > 5)
            <div class="card-footer bg-white border-0 py-3 text-center">
                <a href="{{ route('supervisor.daily-reports.index') }}" class="btn btn-link text-info">
                    Lihat {{ $totalDailyReports - 5 }} laporan lainnya
                    <i class="fas fa-chevron-right ms-1"></i>
                </a>
            </div>
        @endif
    </div>
</div>
<!-- ==================== END DAILY REPORTS SECTION ==================== -->

<!-- Modal Detail Daily Report -->
<div class="modal fade" id="dailyDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line text-info me-2"></i>
                    Detail Daily Report
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="dailyModalDetailContent">
                <!-- Konten akan diisi via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<!-- Additional Tools -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 bg-light shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-bell text-primary me-2 mt-1 fa-lg"></i>
                        <div>
                            <small class="fw-bold d-block">Pengingat Monitoring</small>
                            <small class="text-muted">
                                Laporan yang memerlukan review akan otomatis muncul di halaman ini. 
                                Waktu response rata-rata: 2 hari kerja.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 bg-light shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-chart-bar text-success me-2 mt-1 fa-lg"></i>
                        <div>
                            <small class="fw-bold d-block">Analytics Tersedia</small>
                            <small class="text-muted">
                                Akses dashboard analitik untuk melihat tren dan performa per divisi.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .monitoring-wrapper {
        padding: 1rem 0;
    }
    
    .monitoring-header {
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
    
    .alert-info {
        border-left: 4px solid #0dcaf0;
        border-radius: 8px;
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
        font-size: 2.5rem;
        line-height: 1;
    }
    
    .stat-icon {
        opacity: 0.8;
    }
    
    .card {
        border-radius: 12px;
    }
    
    .division-icon .icon-wrapper {
        width: 45px;
        height: 45px;
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
    
    .progress {
        border-radius: 10px;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    
    .avatar-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .task-info, .pic-info {
        min-width: 180px;
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
    
    @media (max-width: 768px) {
        .monitoring-header {
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
            font-size: 2rem;
        }
        
        .stat-icon i {
            font-size: 1.75rem !important;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .header-actions .btn {
            flex: 1;
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .table th, .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .division-icon .icon-wrapper {
            width: 40px;
            height: 40px;
        }
        
        .task-info, .pic-info {
            min-width: 150px;
        }
        
        .btn-group {
            flex-wrap: nowrap;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .monitoring-wrapper {
            padding: 0.5rem;
        }
        
        .monitoring-header {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-info {
            padding: 1rem !important;
        }
        
        .row.g-3 {
            margin-bottom: 1rem !important;
        }
        
        .card-body {
            padding: 0 !important;
        }
        
        .table td {
            padding: 0.625rem 0.375rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
        }
        
        .progress-wrapper {
            min-width: 120px !important;
        }
        
        .avatar-placeholder {
            width: 28px !important;
            height: 28px !important;
            margin-right: 0.5rem !important;
        }
        
        .pic-info .text-muted {
            font-size: 0.75rem;
        }

        /* Daily Reports Section */
.daily-reports-section {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #eaeaea;
}

.daily-reports-section .section-header {
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.daily-reports-section .avatar-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #0dcaf0;
}

.daily-reports-section .table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.daily-reports-section .table td {
    vertical-align: middle;
}

.daily-reports-section .text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.daily-reports-section .badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

/* Modal Daily Report */
#dailyDetailModal .modal-content {
    border-radius: 12px;
    border: none;
}

#dailyDetailModal .modal-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

#dailyDetailModal .modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

#dailyDetailModal .card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

#dailyDetailModal img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .daily-reports-section .table td,
    .daily-reports-section .table th {
        padding: 0.75rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .daily-reports-section .avatar-placeholder {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.875rem;
    }
    
    .daily-reports-section .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.btn') && !e.target.closest('.badge')) {
                const taskName = this.querySelector('.task-info strong').textContent;
                const division = this.querySelector('.division-icon + div strong').textContent;
                console.log(`View monitoring details for ${taskName} (${division})`);
            }
        });
    });

    const filterItems = document.querySelectorAll('.dropdown-item');
    filterItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filterType = this.closest('.dropdown-menu').previousElementSibling.textContent;
            const filterValue = this.textContent;
            console.log(`Filter ${filterType}: ${filterValue}`);

            filterItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const exportBtn = document.querySelector('.btn-primary');
    if (exportBtn && exportBtn.textContent.includes('Export')) {
        exportBtn.addEventListener('click', function() {
            console.log('Export monitoring data');
        });
    }

    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const value = parseInt(bar.style.width);
        if (value < 30) {
            bar.className = 'progress-bar bg-danger';
        } else if (value < 70) {
            bar.className = 'progress-bar bg-warning';
        } else if (value < 100) {
            bar.className = 'progress-bar bg-info';
        } else {
            bar.className = 'progress-bar bg-success';
        }
    });

    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const newStatus = this.getAttribute('data-new-status');

            if (confirm(`Apakah Anda yakin ingin mengubah status tugas ini menjadi '${newStatus}'?`)) {
                fetch(`/supervisor/tasks/${taskId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Status berhasil diubah menjadi ${newStatus}!`);
                        window.location.reload(); 
                    } else {
                        alert('Gagal mengubah status: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan koneksi.');
                });
            }
        });
    });
});

// Tambahkan ini di dalam blok <script> Anda

function showImagePreview(imageUrl, title) {
    const imgTarget = document.getElementById('previewImageTarget');
    const titleTarget = document.getElementById('previewImageTitle');
    
    // Ganti source gambar
    imgTarget.src = imageUrl;
    
    // Ganti judul modal jika ada
    if(title) {
        titleTarget.innerHTML = `<i class="fas fa-image me-2 text-primary"></i> ${title}`;
    }

    // Munculkan modal
    const previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    previewModal.show();
}

// Daily Reports Modal
document.querySelectorAll('.view-daily-detail').forEach(button => {
    button.addEventListener('click', function() {
        const report = JSON.parse(this.getAttribute('data-report'));
        const user = JSON.parse(this.getAttribute('data-user'));
        
        const modalContent = document.getElementById('dailyModalDetailContent');
        const reportDate = new Date(report.report_date).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        let documentationHtml = '';
        if (report.documentation) {
            documentationHtml = `
                <div class="mb-3">
                    <label class="form-label fw-bold">Dokumentasi:</label><br>
                    <a href="/storage/${report.documentation}" target="_blank">
                        <img src="/storage/${report.documentation}" 
                             alt="Dokumentasi" 
                             class="img-fluid rounded" 
                             style="max-height: 300px;">
                    </a>
                </div>
            `;
        }
        
        modalContent.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Laporan:</label>
                        <p>${reportDate}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama PIC:</label>
                        <div class="d-flex align-items-center">
                            <div class="avatar-placeholder bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width: 40px; height: 40px;">
                                ${user.name.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">${user.name}</p>
                                <small class="text-muted">${user.email}</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Divisi:</label>
                        <p>${user.division ? user.division.name : '-'}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dibuat pada:</label>
                        <p>${new Date(report.created_at).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Terakhir diupdate:</label>
                        <p>${new Date(report.updated_at).toLocaleString('id-ID')}</p>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Task:</label>
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="mb-0">${report.task}</p>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi:</label>
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="mb-0">${report.description}</p>
                    </div>
                </div>
            </div>
            
            ${documentationHtml}
        `;
    });
});
</script>
<div class="modal fade" id="imagePreviewModal" tabindex="-3" aria-hidden="true" style="z-index: 2050;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom-0 pb-0">
                <h6 class="modal-title fw-bold text-dark" id="previewImageTitle">
                    <i class="fas fa-image me-2 text-primary"></i>Pratinjau Foto
                </h6>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-3 text-center">
                <div class="img-container bg-light rounded p-2 border">
                    <img id="previewImageTarget" src="" 
                         class="img-fluid rounded" 
                         style="max-height: 65vh; width: auto; object-fit: contain;">
                </div>
            </div>
            
            <div class="modal-footer border-0 pt-0 justify-content-center">

            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<style>
    /* Overlay latar belakang (backdrop) dibuat agak putih transparan */
    #imagePreviewModal .modal-backdrop {
        background-color: rgba(255, 255, 255, 0.8) !important;
    }

    #imagePreviewModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    /* Memastikan gambar tidak kebesaran dan tidak pecah */
    #previewImageTarget {
        /* 65vh artinya 65% dari tinggi layar, jadi header & footer modal tetap kelihatan */
        max-height: 65vh !important;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .img-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }

    /* Efek hover pada gambar di tabel detail */
    .img-preview-trigger {
        cursor: zoom-in;
        transition: transform 0.2s ease-in-out;
    }

    .img-preview-trigger:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>

@endsection