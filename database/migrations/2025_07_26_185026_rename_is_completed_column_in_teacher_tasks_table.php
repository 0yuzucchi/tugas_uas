<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('teacher_tasks', function (Blueprint $table) {
        $table->renameColumn('is_completed', 'completed');
    });
}

public function down(): void
{
    Schema::table('teacher_tasks', function (Blueprint $table) {
        $table->renameColumn('completed', 'is_completed');
    });
}

};
