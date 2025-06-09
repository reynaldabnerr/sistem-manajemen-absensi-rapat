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
        Schema::table('rapats', function (Blueprint $table) {
            $table->string('penandatangan_jabatan')->nullable();
            $table->string('penandatangan_nama')->nullable();
            $table->string('penandatangan_nip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            $table->dropColumn(['penandatangan_jabatan', 'penandatangan_nama', 'penandatangan_nip']);
        });
    }
};
