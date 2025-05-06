<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapats', function (Blueprint $table) {
            $table->id();
            $table->string('noDokumen_rapat');
            $table->string('noRevisi_rapat')->nullable();
            $table->date('tgl_berlaku_rapat');
            $table->string('agenda_rapat');
            $table->string('hari_rapat');
            $table->date('tanggal_rapat');
            $table->string('lokasi_rapat');
            $table->uuid('link_absensi')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapats');
    }
};
