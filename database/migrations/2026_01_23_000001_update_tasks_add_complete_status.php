<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Modify the status enum to include 'complete'
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'submitted', 'approved', 'rejected', 'complete'])
                ->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Revert to original enum
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'submitted', 'approved', 'rejected'])
                ->default('pending')->change();
        });
    }
};
