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
        Schema::table('kehadiran_rapat', function (Blueprint $table) {
            $table->string('status')->default('pegawai');
            $table->string('instansi')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadiran_rapat', function (Blueprint $table) {
            $table->dropColumn(['status', 'instansi', 'no_telepon', 'email']);
        });
    }
};
