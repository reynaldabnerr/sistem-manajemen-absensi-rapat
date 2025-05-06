<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran_rapat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapat_id')->constrained()->onDelete('cascade'); // Relasi ke rapat
            $table->string('nama');
            $table->string('nip_nik');
            $table->string('unit_kerja');
            $table->string('jabatan_tugas');
            $table->longText('tanda_tangan');
            $table->timestamps();

            // Composite unique constraint untuk nip_nik dan rapat_id
            $table->unique(['nip_nik', 'rapat_id']);  // Menghindari duplikasi NIP/NIK pada satu rapat
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran_rapat');
    }
};
