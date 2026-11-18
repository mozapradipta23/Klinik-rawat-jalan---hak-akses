<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poli', function (Blueprint $table) {
            $table->increments('id_poli');
            $table->string('nama_poli', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poli');
    }
};
