<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pemilihans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilihan');
            $table->date('tanggal_pemilihan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilihan');
    }
};
