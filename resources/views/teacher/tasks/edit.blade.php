@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Tugas</h4>
        </div>

        <div class="card-body">
            {{-- Error Notification --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teacher.tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Judul Tugas</label>
                    <input type="text" id="title" name="title" class="form-control" 
                        value="{{ old('title', $task->title) }}" required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" rows="4"
                        placeholder="Tulis deskripsi jika ada...">{{ old('description', $task->description) }}</textarea>
                </div>

                {{-- Deadline --}}
                <div class="mb-3">
                    <label for="due_date" class="form-label fw-semibold">Tanggal Deadline</label>
                    <input type="date" id="due_date" name="due_date" class="form-control" 
                        value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d')) }}">
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status Prioritas</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">-- Pilih Prioritas --</option>
                        <option value="penting_sekali" {{ old('status', $task->status) == 'penting_sekali' ? 'selected' : '' }}>Penting Sekali</option>
                        <option value="menengah" {{ old('status', $task->status) == 'menengah' ? 'selected' : '' }}>Menengah</option>
                        <option value="tidak_harus" {{ old('status', $task->status) == 'tidak_harus' ? 'selected' : '' }}>Tidak Harus</option>
                    </select>
                </div>

                {{-- Pilih Siswa --}}
<div class="mb-3">
    <label for="student_id" class="form-label fw-semibold">Siswa Penerima</label>
    <select id="student_id" name="student_id" class="form-select" required>
        <option value="">-- Pilih Siswa --</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id', $task->student_id) == $student->id ? 'selected' : '' }}>
                {{ $student->name }}
            </option>
        @endforeach
    </select>
</div>

                {{-- Checkbox --}}
                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" id="is_completed" name="is_completed" value="1"
                        {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_completed">Tandai sebagai selesai</label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('teacher.tasks.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
