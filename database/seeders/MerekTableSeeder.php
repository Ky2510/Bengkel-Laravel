<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MerekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hashedCode = Hash::make(mt_rand(1, 999999));
        DB::table('merek')->insert([
            [
                'nama' => 'Yamaha',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Honda',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Suzuki',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Kawasaki',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Michelin',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'NGK',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'K&N',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'DID',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Motul',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Mikuni',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
        ]);
    }
}
