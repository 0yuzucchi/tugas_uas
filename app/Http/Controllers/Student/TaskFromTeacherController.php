<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\TeacherTask;

class TaskFromTeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = TeacherTask::where('student_id', Auth::id());

        $today = Carbon::today();
        $threeDaysLater = Carbon::today()->addDays(3);

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 📂 Filter Status
        $allowedStatus = ['penting_sekali', 'menengah', 'tidak_harus'];
        $selectedStatus = $request->input('status');
        if ($selectedStatus && in_array($selectedStatus, $allowedStatus)) {
            $query->where('status', $selectedStatus);
        }

        // 📅 Filter Hari Ini
        if ($request->has('today') && $request->today == '1') {
            $query->whereDate('due_date', $today);
        }

        // ⏳ Filter Upcoming (belum selesai dan dalam 3 hari)
        if ($request->has('upcoming') && $request->upcoming == '1') {
            $query->whereBetween('due_date', [$today, $threeDaysLater])
                  ->where('is_completed', 0);
        }

        // 🔃 Sorting
        $sortBy = $request->input('sort_by');
        if (in_array($sortBy, ['due_date', 'status'])) {
            $query->orderBy($sortBy, 'asc');
        } else {
            $query->latest(); // default
        }

        $tasks = $query->get();

        // Hitung jumlah
        $teacherTaskCount = $tasks->count();

        $todayCount = TeacherTask::where('student_id', Auth::id())
            ->whereDate('due_date', $today)
            ->count();

        $upcomingCount = TeacherTask::where('student_id', Auth::id())
            ->whereBetween('due_date', [$today, $threeDaysLater])
            ->where('is_completed', 0)
            ->count();

        $workCount = TeacherTask::where('student_id', Auth::id())
            ->where('status', 'penting_sekali')
            ->count();

        $list1Count = TeacherTask::where('student_id', Auth::id())
            ->where('status', 'menengah')
            ->count();

        return view('student.teacher_tasks', [
            'tasks' => $tasks,
            'teacherTaskCount' => $teacherTaskCount,
            'workCount' => $workCount,
            'list1Count' => $list1Count,
            'todayCount' => $todayCount,
            'upcomingCount' => $upcomingCount,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $selectedStatus,
                'sort_by' => $sortBy,
                'today' => $request->input('today'),
                'upcoming' => $request->input('upcoming'),
            ]
        ]);
    }
}
