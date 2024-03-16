<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hashedCode = Hash::make(mt_rand(1, 999999));
        DB::table('satuan')->insert([
            [
                'nama' => 'Buah',
                'slug' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Botol',
                'slug' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Liter',
                'slug' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Kilogram',
                'slug' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Meter',
                'slug' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Set',
                'slug' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
        ]);
    }
}
