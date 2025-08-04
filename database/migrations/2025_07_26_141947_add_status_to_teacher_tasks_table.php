<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTeacherTasksTable extends Migration
{
    public function up()
    {
        Schema::table('teacher_tasks', function (Blueprint $table) {
            $table->string('status')->default('belum dikerjakan')->after('student_id');
        });
    }

    public function down()
    {
        Schema::table('teacher_tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
