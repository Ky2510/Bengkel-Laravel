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
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->index();
            $table->foreignId('id_pembelian')->index();
            $table->foreignId('id_kategori')->index();
            $table->foreignId('id_merek')->index();
            $table->foreignId('id_satuan')->index();
            $table->foreignId('id_barang')->index();
            $table->string('quantity');
            $table->enum('status', ['Belum dibayar', 'Sudah dibayar'])->default('Belum dibayar');
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
        Schema::dropIfExists('keranjang');
    }
};
