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
        Schema::create('checkout', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi');
            $table->foreignId('id_user')->index();
            $table->foreignId('id_keranjang')->index();
            $table->foreignId('id_bank')->index();
            $table->string('noRek');
            $table->string('namaRek');
            $table->string('status_pengiriman')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->date('barang_diterima')->nullable();
            $table->enum('status', ['Konfirmasi', 'Belum Konfirmasi'])->default('Belum Konfirmasi');
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
        Schema::dropIfExists('checkout');
    }
};
