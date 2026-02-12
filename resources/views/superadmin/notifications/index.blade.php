@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Notifikasi</h5>
            <div>
                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#createNotificationModal">Buat Notifikasi</button>
                <form method="POST" action="{{ route('superadmin.notifications.readAll') }}" style="display:inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">Tandai Semua Dibaca</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if(isset($created) && $created->isNotEmpty())
                <h6 class="mb-3">Notifikasi yang Dibuat</h6>
                <div class="mb-4">
                    <div class="list-group">
                        @foreach($created as $c)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">{{ $c->title }}</div>
                                    <div class="text-muted small">{{ $c->message }}</div>
                                </div>
                                <div class="text-muted small">{{ \Carbon\Carbon::parse($c->created_at)->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($notifications->isEmpty())
                <div class="text-center text-muted py-4">Belum ada notifikasi</div>
            @else
                <div class="list-group">
                    @foreach($notifications as $n)
                        <div class="list-group-item d-flex justify-content-between align-items-start {{ $n->read_at ? 'bg-light' : '' }}">
                            <div>
                                <div class="fw-bold">{{ $n->data['title'] ?? ($n->type ?? 'Notifikasi') }}</div>
                                <div class="text-muted small">{{ $n->data['message'] ?? json_encode($n->data) }}</div>
                            </div>
                            <div class="text-end">
                                <div class="text-muted small">{{ $n->created_at->diffForHumans() }}</div>
                                @if(!$n->read_at)
                                    <form method="POST" action="{{ route('superadmin.notifications.read', $n->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-primary mt-2">Tandai dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<!-- Create Notification Modal -->
<div class="modal fade" id="createNotificationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('superadmin.notifications.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Buat Notifikasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan</label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kirim ke</label>
                        <div>
                            <label class="me-3"><input type="checkbox" name="roles[]" value="PIC" checked> PIC</label>
                            <label><input type="checkbox" name="roles[]" value="supervisor" checked> Supervisor</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
