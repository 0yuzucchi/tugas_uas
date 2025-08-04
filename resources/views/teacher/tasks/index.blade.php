@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Daftar Tugas Diberikan</h3>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-secondary">Logout</button>
        </form>
    </div>

    <a href="{{ route('teacher.tasks.create') }}" class="btn btn-success mb-4">Tambah Tugas Baru</a>

    @if($tasks->count())
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tasks as $task)
                <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title fw-semibold">{{ $task->title }}</h5>

                            {{-- Deskripsi dengan "Selengkapnya" --}}
                            @php
                                $limit = 80;
                                $isLong = strlen($task->description) > $limit;
                                $shortDesc = $isLong
                                    ? Str::limit($task->description, $limit)
                                    : $task->description;
                            @endphp

                            <p class="card-text">
                                {!! nl2br(e($shortDesc)) !!}
                                @if ($isLong)
                                    <a href="#" class="text-primary small" data-bs-toggle="modal"
                                        data-bs-target="#descModal{{ $task->id }}"> Selengkapnya</a>
                                @endif
                            </p>

                            {{-- Modal Deskripsi Lengkap --}}
                            @if ($isLong)
                                <div class="modal fade" id="descModal{{ $task->id }}" tabindex="-1"
                                    aria-labelledby="descModalLabel{{ $task->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="descModalLabel{{ $task->id }}">
                                                    Deskripsi Lengkap</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! nl2br(e($task->description)) !!}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Deadline --}}
                            <span class="badge bg-{{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'danger' : 'info' }} d-block mt-2">
                                {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d M Y') }}
                            </span>

                            {{-- Status Prioritas --}}
                            @php
                                $badgeClass = match ($task->status) {
                                    'penting sekali', 'penting_sekali' => 'danger',
                                    'menengah' => 'warning',
                                    'tidak harus', 'tidak_harus' => 'secondary',
                                    default => 'light',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} mt-1">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>

                            {{-- Status Selesai --}}
                            <span class="badge bg-{{ $task->is_completed ? 'success' : 'secondary' }} mt-1">
                                {{ $task->is_completed ? 'Selesai' : 'Belum Selesai' }}
                            </span>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="card-footer bg-transparent border-top-0 d-flex justify-content-end gap-2">
                            <a href="{{ route('teacher.tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada tugas yang dibuat.</div>
    @endif
</div>
@endsection
