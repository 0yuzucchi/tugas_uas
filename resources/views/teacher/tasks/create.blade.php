@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Buat Tugas Baru</h4>
        </div>

        <div class="card-body">
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

            <form action="{{ route('teacher.tasks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="student_id" class="form-label">Pilih Siswa</label>
                    <select name="student_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Siswa --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Tugas</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Kerjakan soal matematika halaman 21" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Tambahkan detail tambahan jika perlu..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="due_date" class="form-label">Tanggal Deadline</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Prioritas</label>
                    <select name="status" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Prioritas --</option>
                        <option value="penting_sekali">Penting Sekali</option>
                        <option value="menengah">Menengah</option>
                        <option value="tidak_harus">Tidak Harus</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('teacher.tasks.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
