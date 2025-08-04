<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        // Format data untuk FullCalendar
        $events = $tasks->map(function ($task) {
            return [
                'title' => $task->title,
                'start' => $task->due_date,
                'url' => route('tasks.edit', $task->id),
                'color' => $task->is_completed ? '#28a745' : '#dc3545', // hijau/merah
            ];
        });

        return view('components.calendar', [
    'events' => $events,
]);

    }
}
