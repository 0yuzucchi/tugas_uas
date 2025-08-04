<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Teacher\TeacherTaskController;
use App\Http\Controllers\Student\TaskFromTeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal
Route::get('/', fn () => view('welcome'));

// Autentikasi
Auth::routes();

// Halaman Home (Setelah Login)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ========================
// Routes untuk Semua User Login
// ========================
Route::middleware(['auth'])->group(function () {
    // To-Do List Pribadi
    Route::resource('tasks', TaskController::class);

    // Filter/Kategori Khusus
    Route::get('/tasks/personal', [TaskController::class, 'personal'])->name('tasks.personal');
    Route::get('/tasks/work', [TaskController::class, 'work'])->name('tasks.work');
    Route::get('/tasks/list1', [TaskController::class, 'list1'])->name('tasks.list1');

    // Kalender Tugas
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // Buat Daftar (opsional)
    Route::get('/lists/create', [TaskController::class, 'createList'])->name('lists.create');
});

// ========================
// Routes Khusus Guru (Teacher)
// ========================
Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/tasks', [TeacherTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TeacherTaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TeacherTaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TeacherTaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TeacherTaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TeacherTaskController::class, 'destroy'])->name('tasks.destroy');
});

// ========================
// Routes Khusus Siswa (Student)
// ========================
Route::middleware(['auth'])->group(function () {
    // Melihat Tugas dari Guru
    Route::get('/student/teacher-tasks', [TaskFromTeacherController::class, 'index'])->name('student.teacher_tasks');
});
