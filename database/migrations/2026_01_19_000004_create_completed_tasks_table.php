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
        Schema::create('completed_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_submission_id');
            $table->unsignedBigInteger('task_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('task_submission_id')->references('id')->on('task_submissions')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            
            $table->unique(['task_submission_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_tasks');
    }
};
