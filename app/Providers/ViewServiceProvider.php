<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\TeacherTask;
use Illuminate\Support\Carbon;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            // Default nilai
            $upcomingCount = 0;
            $dueInThreeDaysCount = 0;
            $teacherTaskCount = 0;
            $workCount = 0;
            $list1Count = 0;
            

            if ($user) {
                $today = Carbon::today();
                $threeDaysLater = $today->copy()->addDays(3);

                if ($user->role === 'student') {
                    // Jumlah tugas dari guru
                    $teacherTaskCount = TeacherTask::where('student_id', $user->id)->count();

                        $upcomingCount = Task::where('is_completed', 0)->count();


         // Tugas pribadi yang due dalam 3 hari (D-3)
    $dueInThreeDaysCount = Task::whereBetween('due_date', [$today, $threeDaysLater])
        ->where('is_completed', 0)
        ->count();

                    // Tugas pribadi yang belum selesai (tanpa user_id)
                    $upcomingCount = Task::where('is_completed', 0)->count();
                }

                


                

                if ($user->role === 'teacher') {
                    // Semua tugas yang dibuat oleh guru
                    $teacherTaskCount = TeacherTask::where('teacher_id', $user->id)->count();

                    // Tugas dari guru yang due dalam 3 hari ke depan
                    $dueInThreeDaysCount = TeacherTask::where('teacher_id', $user->id)
                        ->whereBetween('due_date', [$today, $threeDaysLater])
                        ->where('is_completed', 0)
                        ->count();

                    // Tugas upcoming dari guru (besok sampai 3 hari lagi)
                    $upcomingCount = TeacherTask::where('teacher_id', $user->id)
                        ->whereBetween('due_date', [Carbon::tomorrow(), $threeDaysLater])
                        ->where('is_completed', 0)
                        ->count();

                    // Tugas "penting sekali"
                    $workCount = TeacherTask::where('teacher_id', $user->id)
                        ->where('status', 'penting_sekali')
                        ->where('is_completed', 0)
                        ->count();

                    // Tugas "menengah"
                    $list1Count = TeacherTask::where('teacher_id', $user->id)
                        ->where('status', 'menengah')
                        ->where('is_completed', 0)
                        ->count();
                        
                }
            }

            $view->with(compact(
                'upcomingCount',
                'dueInThreeDaysCount',
                'teacherTaskCount',
                'workCount',
                'list1Count'
            ));
        });
    }
}
