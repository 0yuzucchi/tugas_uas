<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Task::query();

    $today = now()->toDateString();
    $threeDaysLater = now()->addDays(3)->toDateString();

    // Filter: Pencarian
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    // Filter: Upcoming (is_completed = 0)
    if ($request->has('is_completed') && $request->is_completed === '0') {
        $query->where('is_completed', 0);
    }

    // Filter: D-3 (due soon)
    if ($request->has('due_soon') && $request->due_soon == '1') {
                $query->where('is_completed', 0);

        $query->whereBetween('due_date', [$today, $threeDaysLater]);
    }

    // Filter: Status
    $allowedStatus = ['penting_sekali', 'menengah', 'tidak_harus'];
    $selectedStatus = $request->input('status');
    if ($selectedStatus && in_array($selectedStatus, $allowedStatus)) {
        $query->where('status', $selectedStatus);
    }

    // Sorting
    $sortBy = $request->input('sort_by');
    if (in_array($sortBy, ['due_date', 'status'])) {
        $query->orderBy($sortBy, 'asc');
    }

    $tasks = $query->get();

    // Hitung jumlah badge
    $upcomingCount = Task::where('is_completed', 0)->count();
    $dueInThreeDaysCount = Task::where('is_completed', 0)
    ->whereBetween('due_date', [$today, $threeDaysLater])
    ->count();


    return view('tasks.index', [
        'tasks' => $tasks,
        'filters' => [
            'sort_by' => $sortBy,
            'status' => $selectedStatus,
            'due_soon' => $request->input('due_soon')
        ],
        'upcomingCount' => $upcomingCount,
        'dueInThreeDaysCount' => $dueInThreeDaysCount,
    ]);
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:penting_sekali,menengah,tidak_harus',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:penting_sekali,menengah,tidak_harus',
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas Berhasil Dihapus');
    }
}
