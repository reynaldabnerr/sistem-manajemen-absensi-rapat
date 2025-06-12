<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNipNikNullableInKehadiranRapatTable extends Migration
{
    public function up()
    {
        Schema::table('kehadiran_rapat', function (Blueprint $table) {
            $table->string('nip_nik')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('kehadiran_rapat', function (Blueprint $table) {
            $table->string('nip_nik')->nullable(false)->change();
        });
    }
}

