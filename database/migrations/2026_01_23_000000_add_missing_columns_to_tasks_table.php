<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add task grouping columns
            if (!Schema::hasColumn('tasks', 'task_group_id')) {
                $table->unsignedBigInteger('task_group_id')->nullable()->after('id');
                $table->foreign('task_group_id')->references('id')->on('tasks')->onDelete('cascade');
            }
            
            // Add child task title
            if (!Schema::hasColumn('tasks', 'task_item_title')) {
                $table->string('task_item_title')->nullable()->after('title');
            }
            
            // Add task order
            if (!Schema::hasColumn('tasks', 'task_order')) {
                $table->integer('task_order')->default(0)->after('task_item_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'task_order')) {
                $table->dropColumn('task_order');
            }
            
            if (Schema::hasColumn('tasks', 'task_item_title')) {
                $table->dropColumn('task_item_title');
            }
            
            if (Schema::hasColumn('tasks', 'task_group_id')) {
                $table->dropForeign(['task_group_id']);
                $table->dropColumn('task_group_id');
            }
        });
    }
};
