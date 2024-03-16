<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            AnggotaTableSeeder::class,
            KategoriTableSeeder::class,
            MerekTableSeeder::class,
            SatuanTableSeeder::class,
            SuplayTableSeeder::class,
            IndoBankSeeder::class,
            PembelianTableSeeder::class,
            BankcompanySeeder::class,
            BarangTableSeeder::class,
        ]);
    }
}
