@extends('layouts.app')

@section('content')
@if (session('status'))
    <script>
        // Simpan status dari session ke JavaScript
        const statusMessage = @json(session('status'));

        // Setelah halaman dimuat, tampilkan notifikasi dan redirect
        window.onload = function () {
            alert(statusMessage); // Bisa diganti dengan SweetAlert atau Toast jika ingin lebih modern
            window.location.href = "{{ route('tasks.index') }}"; // Ganti sesuai rute kamu
        };
    </script>
@else
    <script>
        // Jika tidak ada pesan, langsung redirect ke /tasks
        window.location.href = "{{ route('tasks.index') }}";
    </script>
@endif
@endsection
