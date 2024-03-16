<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('anggota')->insert([
            'nama' => 'SuperAdmin',
            'jeniskelamin' => 'Pria', // Atau 'Wanita'
            'tpt_lhr' => 'Land Of Down',
            'tgl_lhr' => '2000-01-01',
            'alamat' => 'Junggler',
            'no_hp' => '081234567890',
            'user_id' => 1,
        ]);
    }
}
