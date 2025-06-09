<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('rapats', function (Blueprint $table) {
            $table->foreignId('unit_kerja_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('rapats', function (Blueprint $table) {
            $table->dropForeign(['unit_kerja_id']);
            $table->dropColumn('unit_kerja_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
