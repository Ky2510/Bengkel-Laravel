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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_merek');
            $table->unsignedBigInteger('id_satuan');
            $table->unsignedBigInteger('id_pembelian');
            $table->string('image')->nullable();
            $table->string('kode');
            $table->timestamps();

            $table->foreign('id_kategori')->on('kategori')->references('id');
            $table->foreign('id_merek')->on('merek')->references('id');
            $table->foreign('id_satuan')->on('satuan')->references('id');
            $table->foreign('id_pembelian')->on('pembelian')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
