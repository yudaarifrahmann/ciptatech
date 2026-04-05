<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_schemas', function (Blueprint $table) {
            $table->string('form_type')->default('weekly')->after('division_id');
            // Remove unique if exists, and add composite unique
            $table->unique(['organization_id', 'division_id', 'form_type']);
        });
    }

    public function down(): void
    {
        Schema::table('form_schemas', function (Blueprint $table) {
            $table->dropUnique(['organization_id', 'division_id', 'form_type']);
            $table->dropColumn('form_type');
        });
    }
};
