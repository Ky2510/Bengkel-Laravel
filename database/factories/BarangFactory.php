<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Satuan;
use App\Models\Pembelian;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_kategori' => function (array $attributes) {
                $kategori = Kategori::inRandomOrder()->first(); 
                return $kategori->id;
            },
            'id_merek' => function (array $attributes) {
                $merek = Merek::inRandomOrder()->first(); 
                return $merek->id;
            },
            'id_satuan' => function (array $attributes) {
                $satuan = Satuan::inRandomOrder()->first(); 
                return $satuan->id;
            },
            'id_pembelian' => function (array $attributes) {
                $pembelian = Pembelian::inRandomOrder()->first(); 
                return $pembelian->id;
            },
            'image' => 'userbg-2.png',
            'kode' => $this->faker->numberBetween(0000, 9999),
        ];
    }
}
