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
        Schema::create('data_kandidats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kandidat');
            $table->string('nik');
            $table->integer('umur_kandidat');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('latar_belakang');
            $table->text('pencapaian');
            $table->string('foto_profile')->nullable(); // Foto kandidat (gunakan file upload)
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kandidat');
    }
};
