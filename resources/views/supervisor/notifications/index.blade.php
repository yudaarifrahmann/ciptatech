@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Notifikasi</h5>
            <div>
                <form method="POST" action="{{ route('supervisor.notifications.readAll') }}" style="display:inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">Tandai Semua Dibaca</button>
                </form>
            </div>
        </div>
        <div class="card-body">
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
                                    <form method="POST" action="{{ route('supervisor.notifications.read', $n->id) }}">
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
