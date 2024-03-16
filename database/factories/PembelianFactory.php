<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Suplay;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembelian>
 */
class PembelianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $daftarBarangMotor = [
            'Oli mesin',
            'Filter oli',
            'Spare part rantai',
            'Busi',
            'Kampas rem',
            'Lampu depan',
            'Lampu belakang',
            'Radiator',
            'Shock absorber',
            'Aki',
            'Ban dalam',
            'Ban luar',
            'Piston',
            'Karburator',
            'Kabel gas',
            'Kabel rem',
            'Sprocket',
            'Gasket',
            'Kopling',
            'Rantai transmisi',
            'Koil',
            'Stang',
            'Handle grip',
            'Kick starter',
            'Kunci kontak',
            'CDI',
            'Spion',
            'Knalpot',
            'Roda gigi',
            'Kruk as',
            'Cylinder head',
            'Stiker pelindung',
            'Cat motor',
            'Baut dan mur',
            'Kabel busi',
            'Rantai sepeda motor',
            'Saklar',
            'Koil spul',
            'Tangki bensin',
            'Jok motor',
            'Kotak filter udara',
            'Saringan udara',
            'Selang bensin',
            'Pipa knalpot',
            'Pedal rem',
            'Roda',
            'Pelek',
            'Kunci roda',
            'Pemantik busi',
            'Aksesoris motor',
            'Sambungan knalpot',
            'Pembersih karburator',
            'Bearing',
            'Koil spul',
            'Meteran bensin',
            'Sensor suhu',
            'Saringan oli',
            'Tutup tangki',
            'Klem selang',
            'Seal',
            'Penyegelan knalpot',
            'Gagang gas',
            'Kampas kopling',
            'Kabel kopling',
            'Koil busi',
            'Rantai timing',
            'Rantai distribusi',
            'Selang radiator',
            'Baut ban',
            'Rantai rem',
            'Oli transmisi',
            'Rantai dorong',
            'Rantai balik',
            'Pelek roda depan',
            'Pelek roda belakang',
            'Bearing roda',
            'Baut rantai',
            'Oli gardan',
            'Koil penyearah',
            'Saringan udara kotak',
            'Saringan udara busi',
            'Saringan udara cartridge',
            'Silinder kopling',
            'Baut kopling',
            'Oli gearbox',
            'Oli shock absorber',
            'Kopling master',
            'Kopling slave',
            'Oli rem',
            'Kabel rem depan',
            'Kabel rem belakang',
            'Selang rem depan',
            'Selang rem belakang',
            'Master rem depan',
            'Master rem belakang',
            'Cylinder rem depan',
            'Cylinder rem belakang',
            'Baut rem depan',
            'Baut rem belakang',
            'Rantai roller',
            'Tangki oli',
            'Kabel gas depan',
            'Kabel gas belakang',
            'Spakbor depan',
            'Spakbor belakang',
            'Karet pelindung',
            'Gantungan kunci',
            'Paket perbaikan',
        ];
        $jenisMotor = [
            'Honda',
            'Yamaha',
            'Suzuki',
            'Kawasaki',
            'Vespa',
            'TVS',
            'KTM',
            'Bajaj',
            'Harley-Davidson',
            'Ducati',
            'Aprilia',
            'Kymco',
            'BMW',
        ];
        $tanggal = $this->faker->dateTimeBetween('2023-01-01', '2023-07-20')->format('Y-m-d');
        return [
            'id_suplay' => function (array $attributes) {
                $suplay = Suplay::inRandomOrder()->first(); 
                return $suplay->id;
            },
            'nama' => $this->faker->randomElement($daftarBarangMotor),
            'jenis' => $this->faker->randomElement($jenisMotor),
            'hargaBeli' => $this->faker->numberBetween(5000000, 30000000), // Angka ini dapat disesuaikan sesuai dengan rentang harga yang Anda inginkan
            'hargaJual' => $this->faker->numberBetween(6000000, 35000000), // Angka ini juga dapat disesuaikan sesuai dengan rentang harga jual yang Anda inginkan
            'stok' => $this->faker->numberBetween(1, 50),
            'created_at' => $tanggal,
        ];
    }
}
