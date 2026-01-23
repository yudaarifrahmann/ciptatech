<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('task_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('task_submissions', 'completed_tasks_count')) {
                $table->integer('completed_tasks_count')->default(0)->after('status');
            }
            
            if (!Schema::hasColumn('task_submissions', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('reviewed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('task_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('task_submissions', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            
            if (Schema::hasColumn('task_submissions', 'completed_tasks_count')) {
                $table->dropColumn('completed_tasks_count');
            }
        });
    }
};
