<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('dokter', function (Blueprint $table) {
        $table->increments('id_dokter');
        $table->string('nama_dokter', 100);
        $table->string('tempat_lahir', 100);
        $table->date('tanggal_lahir');
        $table->string('no_sip', 50)->unique();
        $table->string('spesialisasi', 100);
        $table->unsignedInteger('id_poli');
        $table->string('kontak', 20);
        $table->string('email', 100);

        $table->foreign('id_poli')->references('id_poli')->on('poli');
    });
}

public function down(): void
{
    Schema::dropIfExists('dokter');
}
};
