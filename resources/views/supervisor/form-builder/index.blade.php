@extends('layouts.app')

@section('title', 'Atur Formulir Laporan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">Atur Formulir Laporan</h5>
                        <p class="text-muted small mb-0">Sesuaikan input yang dibutuhkan untuk PIC di divisi Anda.</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-4 bg-light p-2 rounded-3">
                    <li class="nav-item">
                        <a class="nav-link {{ $type == 'weekly' ? 'active shadow-sm' : '' }}" href="{{ route('supervisor.form-builder.index', ['type' => 'weekly']) }}">
                            <i class="fas fa-calendar-week me-1"></i> Laporan Mingguan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type == 'daily' ? 'active shadow-sm' : '' }}" href="{{ route('supervisor.form-builder.index', ['type' => 'daily']) }}">
                            <i class="fas fa-calendar-day me-1"></i> Laporan Harian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type == 'submission' ? 'active shadow-sm' : '' }}" href="{{ route('supervisor.form-builder.index', ['type' => 'submission']) }}">
                            <i class="fas fa-tasks me-1"></i> Submit Tugas
                        </a>
                    </li>
                </ul>

                <form action="{{ route('supervisor.form-builder.store') }}" method="POST" id="formBuilder">
                    @csrf
                    <input type="hidden" name="form_type" value="{{ $type }}">
                    
                    <div class="mb-4">
                        @php
                            $labels = [
                                'weekly' => 'Tambahan untuk Laporan Mingguan PIC',
                                'daily' => 'Tambahan untuk Laporan Harian PIC',
                                'submission' => 'Tambahan saat PIC Submit Tugas Tertentu'
                            ];
                        @endphp
                        <h6 class="fw-bold mb-1"><i class="fas fa-cog me-1"></i> Konfigurasi Bidang {{ $labels[$type] }}</h6>
                        <small class="text-muted">Field yang Anda tambahkan di bawah akan muncul secara otomatis di akun PIC saat mereka mengisi {{ $labels[$type] }}.</small>
                    </div>

                    <div id="fieldsContainer">
                        @if($schema && is_array($schema->schema))
                            @foreach($schema->schema as $index => $field)
                                <div class="field-item card mb-3 border bg-light shadow-none rounded-3 p-3" data-index="{{ $index }}">
                                    <div class="row align-items-end g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Label Input</label>
                                            <input type="text" name="fields[{{ $index }}][label]" class="form-control" value="{{ $field['label'] }}" placeholder="Misal: Lokasi Kunjungan" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Tipe</label>
                                            <select name="fields[{{ $index }}][type]" class="form-select" required>
                                                <option value="text" {{ $field['type'] == 'text' ? 'selected' : '' }}>Teks Pendek</option>
                                                <option value="textarea" {{ $field['type'] == 'textarea' ? 'selected' : '' }}>Teks Panjang (Paragraf)</option>
                                                <option value="number" {{ $field['type'] == 'number' ? 'selected' : '' }}>Angka</option>
                                                <option value="date" {{ $field['type'] == 'date' ? 'selected' : '' }}>Tanggal</option>
                                                <option value="file" {{ $field['type'] == 'file' ? 'selected' : '' }}>Upload File/Foto</option>
                                                <option value="select" {{ $field['type'] == 'select' ? 'selected' : '' }}>Pilihan (Dropdown)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="fields[{{ $index }}][required]" value="1" {{ isset($field['required']) && $field['required'] ? 'checked' : '' }}>
                                                <label class="form-check-label small fw-bold">Wajib Isi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-field">
                                                <i class="fas fa-trash-alt"></i> Hapus Field
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center py-5 empty-state">
                                <div class="mb-3">
                                    <i class="fas fa-list-check fa-4x text-light opacity-50"></i>
                                </div>
                                <h5 class="text-muted mb-3">Belum ada field tambahan.</h5>
                                <p class="text-muted small mb-4">Klik tombol di bawah atau tomboh "Tambah" untuk mulai membuat formulir kustom.</p>
                                <button type="button" class="btn btn-primary rounded-pill px-4 btn-add-first">
                                    <i class="fas fa-plus me-1"></i> Mulai Tambah Field
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-outline-primary rounded-pill me-2" id="addField">
                            <i class="fas fa-plus me-1"></i> Tambah Field Baru
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let fieldIndex = {{ $schema && is_array($schema->schema) ? count($schema->schema) : 0 }};

    const addFieldFn = function() {
        const emptyState = document.querySelector('.empty-state');
        if (emptyState) emptyState.remove();

        const container = document.getElementById('fieldsContainer');
        const fieldHtml = `
            <div class="field-item card mb-3 border bg-light shadow-none rounded-3 p-3 animate__animated animate__fadeInUp" data-index="${fieldIndex}">
                <div class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Label Input</label>
                        <input type="text" name="fields[${fieldIndex}][label]" class="form-control" placeholder="Misal: Lokasi Kunjungan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tipe</label>
                        <select name="fields[${fieldIndex}][type]" class="form-select" required>
                            <option value="text">Teks Pendek</option>
                            <option value="textarea">Teks Panjang (Paragraf)</option>
                            <option value="number">Angka</option>
                            <option value="date">Tanggal</option>
                            <option value="file">Upload File/Foto</option>
                            <option value="select">Pilihan (Dropdown)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="fields[${fieldIndex}][required]" value="1" checked>
                            <label class="form-check-label small fw-bold">Wajib Isi</label>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-field">
                            <i class="fas fa-trash-alt"></i> Hapus Field
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', fieldHtml);
        fieldIndex++;
    };

    document.getElementById('addField').addEventListener('click', addFieldFn);
    
    // Support for the first button in empty state
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-first')) {
            addFieldFn();
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-field')) {
            const item = e.target.closest('.field-item');
            item.classList.add('animate__animated', 'animate__fadeOutDown');
            setTimeout(() => {
                item.remove();
                if (document.querySelectorAll('.field-item').length === 0) {
                    // Create an empty input to ensure 'fields' is sent as an empty array if needed, though PHP handles null
                    const formBuilder = document.getElementById('formBuilder');
                    const emptyField = document.createElement('input');
                    emptyField.type = 'hidden';
                    emptyField.name = 'empty_submission';
                    emptyField.value = '1';
                    formBuilder.appendChild(emptyField);
                    
                    formBuilder.submit(); // Auto-submit to avoid user confusion
                }
            }, 300);
        }
    });
</script>
@endpush
@endsection
