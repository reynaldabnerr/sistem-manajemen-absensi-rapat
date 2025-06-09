<?php

// database/migrations/xxxx_add_unit_kerja_id_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('unit_kerja_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unit_kerja_id');
        });
    }
};
