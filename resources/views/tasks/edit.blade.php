@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow rounded">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Tugas</h4>
            </div>

            <div class="card-body">
                {{-- Error Notification --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups! Ada kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Tugas</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                    </div>

                    {{-- Tanggal Deadline --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Prioritas</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="penting_sekali" {{ old('status', $task->status) == 'penting_sekali' ? 'selected' : '' }}>Penting Sekali</option>
                            <option value="menengah" {{ old('status', $task->status) == 'menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="tidak_harus" {{ old('status', $task->status) == 'tidak_harus' ? 'selected' : '' }}>Tidak Harus</option>
                        </select>
                    </div>

                    {{-- Checkbox Completed --}}
                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="is_completed" name="is_completed" value="1" {{ $task->is_completed ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_completed">Tandai sebagai selesai</label>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
