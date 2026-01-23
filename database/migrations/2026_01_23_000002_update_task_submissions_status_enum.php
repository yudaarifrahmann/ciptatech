<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Change the enum to include 'completed'
        DB::statement("ALTER TABLE task_submissions MODIFY status ENUM('submitted', 'completed', 'approved', 'rejected') DEFAULT 'submitted'");
    }

    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE task_submissions MODIFY status ENUM('submitted', 'approved', 'rejected') DEFAULT 'submitted'");
    }
};
