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
        Schema::create('service_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_layananservice')->index();
            $table->foreignId('id_barang')->nullable();
            $table->foreignId('id_anggota')->nullable();
            $table->string('stok_barang')->nullable();
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
        Schema::dropIfExists('service_barangs');
    }
};
