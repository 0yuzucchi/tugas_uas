<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherTask;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon; // tambahkan ini di atas

class TeacherTaskController extends Controller
{
    public function index()
    {
        $tasks = TeacherTask::with('student')
            ->where('teacher_id', Auth::id())
            ->latest()
            ->get();

        return view('teacher.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('teacher.tasks.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:penting_sekali,menengah,tidak_harus',
        ]);

        TeacherTask::create([
            'teacher_id' => Auth::id(),
            'student_id' => $request->student_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('teacher.tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }


public function edit(TeacherTask $task)
{
    if ($task->teacher_id !== Auth::id()) {
        abort(403);
    }

    // Konversi ke Carbon
    $task->due_date = Carbon::parse($task->due_date);

    $students = User::where('role', 'student')->get();
    return view('teacher.tasks.edit', compact('task', 'students'));
}


    public function update(Request $request, TeacherTask $task)
    {
        if ($task->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:penting_sekali,menengah,tidak_harus', // sudah diperbaiki
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'student_id' => $request->student_id,
            'status' => $request->status,
        ]);

        return redirect()->route('teacher.tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(TeacherTask $task)
    {
        if ($task->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
    }
}
