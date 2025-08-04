@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Tugas Baru</h4>
            </div>

            <div class="card-body">
                {{-- Tampilkan Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups! Ada masalah dengan input kamu:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Tugas</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Tambahkan catatan jika perlu...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Tanggal Deadline --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Prioritas</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="penting_sekali" {{ old('status') == 'penting_sekali' ? 'selected' : '' }}>🔥 Penting Sekali</option>
                            <option value="menengah" {{ old('status') == 'menengah' ? 'selected' : '' }}>📌 Menengah</option>
                            <option value="tidak_harus" {{ old('status') == 'tidak_harus' ? 'selected' : '' }}>🕓 Tidak Harus</option>
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            Simpan Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
