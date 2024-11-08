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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('unit_apartement');
            $table->string('nomor_unit_apartement');
            $table->string('email')->unique();
            $table->string('no_telephone');
            $table->string('password');
            $table->enum('role', ['admin', 'user']);
            $table->string('token')->nullable();
            $table->string('upload_image')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
