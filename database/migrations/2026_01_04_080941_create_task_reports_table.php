<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // PIC / user login
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->integer('progress')->default(0);
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'progress', 'menunggu review', 'selesai'])->default('progress');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_reports');
    }
};
