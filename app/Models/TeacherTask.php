<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherTask extends Model
{
    use HasFactory;

    protected $fillable = [
    'teacher_id',
    'student_id',
    'title',
    'description',
    'due_date',
    'status', // ✅ tambahkan ini
];



    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function student()
{
    return $this->belongsTo(User::class, 'student_id');
}

}
