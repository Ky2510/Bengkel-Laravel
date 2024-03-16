<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $hashedCode = Hash::make(mt_rand(1, 999999));
        DB::table('kategori')->insert([
            [
                'nama' => 'Oli',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Suku Cadang',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Ban',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Karburator',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Busi',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Saringan Udara',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Rantai',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
            [
                'nama' => 'Oli Rem',
                'kode' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ],
        ]);
    }
}
