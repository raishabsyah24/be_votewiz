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
        Schema::create('pemilihan_kandidats', function (Blueprint $table) {
            $table->id();
            $table->integer('no_urut');
            $table->foreignId('kandidat_id')->constrained('data_kandidats'); // Relasi dengan tabel data_kandidats
            $table->foreignId('posisi_id')->constrained('posisi_kandidats'); // Relasi dengan tabel posisi_kandidats
            $table->string('slogan');
            $table->string('visi_misi_path'); // Menyimpan path untuk file visi misi
            $table->foreignId('nama_pemilihan_id')->constrained('pemilihans'); // Relasi dengan tabel pemilihans
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilihan_kandidats');
    }
};
