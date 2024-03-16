<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanan_services', function (Blueprint $table) {
            $table->id();
            $table->string('id_layanan');
            $table->string('nama_motor');
            $table->enum('jenis_motor', ['kopling', 'matic', 'gigi', 'karbu']);
            $table->foreignId('id_datauser');
            $table->enum('barang', ['true', 'false'])->nullable();
            $table->text('keluhan');
            $table->enum('status', ['konfirmasi', 'belum konfirmasi'])->default('belum konfirmasi');
            $table->foreignId('id_anggota')->nullable();
            $table->string('harga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanan_services');
    }
};
