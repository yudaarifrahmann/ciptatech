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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        Schema::table('task_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        Schema::table('daily_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        Schema::table('task_submissions', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) { $table->dropForeign(['organization_id']); $table->dropColumn('organization_id'); });
        Schema::table('task_reports', function (Blueprint $table) { $table->dropForeign(['organization_id']); $table->dropColumn('organization_id'); });
        Schema::table('daily_reports', function (Blueprint $table) { $table->dropForeign(['organization_id']); $table->dropColumn('organization_id'); });
        Schema::table('task_submissions', function (Blueprint $table) { $table->dropForeign(['organization_id']); $table->dropColumn('organization_id'); });
    }
};
