<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('supervisor_id'); // Supervisor yang membuat tugas
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'submitted', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('division_id')
                  ->references('id')->on('divisions')
                  ->onDelete('cascade');
            
            $table->foreign('supervisor_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
