@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4><i class="fa-solid fa-building"></i> Manajemen Divisi</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Divisi</th>
                <th>Admin Divisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($divisions as $division)
            <tr>
                <td>{{ $division->name }}</td>
                <td>{{ $division->admin->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
