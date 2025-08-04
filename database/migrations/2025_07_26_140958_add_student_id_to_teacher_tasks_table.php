<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('teacher_tasks', function (Blueprint $table) {
        $table->foreignId('student_id')->constrained('users')->after('teacher_id');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_tasks', function (Blueprint $table) {
            //
        });
    }
};
