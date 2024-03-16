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
        Schema::create('kirim_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_checkout')->index();
            $table->foreignId('id_anggota')->index();
            $table->enum('status_barang', ['diterima', 'belum diterima']);
            $table->enum('konfirmasi_barang', ['aktif', 'tidak aktif']);
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
        Schema::dropIfExists('kirim_barangs');
    }
};
