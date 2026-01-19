<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add columns to tasks table for grouping multiple tasks
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('task_group_id')->nullable()->after('supervisor_id');
            $table->integer('task_order')->default(0)->after('task_group_id');
            $table->string('task_item_title')->nullable()->after('description');
        });

        // Add completed_at to task_submissions
        Schema::table('task_submissions', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('reviewed_at');
            $table->integer('completed_tasks_count')->default(0)->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['task_group_id', 'task_order', 'task_item_title']);
        });

        Schema::table('task_submissions', function (Blueprint $table) {
            $table->dropColumn(['completed_at', 'completed_tasks_count']);
        });
    }
};
