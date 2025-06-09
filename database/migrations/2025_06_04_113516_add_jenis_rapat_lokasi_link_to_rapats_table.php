<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            $table->enum('jenis_rapat', ['offline', 'online', 'hybrid'])->default('offline');
            $table->string('lokasi_rapat')->nullable()->change(); // kalau sudah ada dan nullable, cukup change
            $table->string('link_meeting')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rapats', function (Blueprint $table) {
            $table->dropColumn(['jenis_rapat', 'link_meeting']);
            // Note: Tidak bisa mengubah kolom kembali ke not null dalam rollback jika awalnya nullable
        });
    }
};
