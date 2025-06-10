<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['unit_kerja_id']);
            $table->dropForeign(['user_id']);
            
            // Make columns nullable
            $table->unsignedBigInteger('unit_kerja_id')->nullable()->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Re-add foreign keys but with onDelete set to SET NULL
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            $table->dropForeign(['unit_kerja_id']);
            $table->dropForeign(['user_id']);
            
            $table->foreignId('unit_kerja_id')->constrained()->cascadeOnDelete()->change();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->change();
        });
    }
};