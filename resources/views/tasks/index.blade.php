@extends('layouts.app')

@section('content')
    <div class="min-vh-100 bg-light">
        {{-- Sidebar --}}
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="ps-4 pe-4 pt-4 pb-4" style="margin-left: 320px; overflow-y: auto;">
            <h2 class="fw-bold mb-4">My To-Do List</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($tasks->isEmpty())
                <p>No tasks found. <a href="{{ route('tasks.create') }}">Add one!</a></p>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($tasks as $task)
                        <div class="col">
                            <div class="card h-100 shadow-sm d-flex flex-column">
                                <div class="card-body d-flex flex-column flex-grow-1">
                                    <h5 class="card-title fw-semibold">{{ $task->title }}</h5>

                                    {{-- Deskripsi dengan "Selengkapnya" sebaris --}}
                                    @php
                                        $limit = 70;
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
                                                        {{ $task->description }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Tanggal Deadline --}}
                                    <span
                                        class="badge bg-{{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'danger' : 'info' }} d-block mt-2">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
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
                                <div class="card-footer mb-2 bg-transparent border-top-0 d-flex justify-content-end gap-2">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
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
            @endif
        </div>
    </div>

    {{-- ✅ CSS --}}
    <style>
        .card-text {
            min-height: 4.5em;
            line-height: 1.5em;
            overflow: hidden;
        }

        .card-text a {
            white-space: nowrap;
            text-decoration: none;
        }

        body,
        html {
            overflow-x: hidden;
            background-color: #f8fafc;
        }
    </style>
@endsection
