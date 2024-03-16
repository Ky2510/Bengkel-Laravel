<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bankcompany;
use App\Models\Bank;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bankcompany>
 */
class BankcompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition()
    {
        return [
            'kode' => function (array $attributes) {
                $bank = Bank::inRandomOrder()->first(); 
                return $bank->sandi_bank;
            },
            'nama_bank' => function (array $attributes) {
                $bank = Bank::where('sandi_bank', $attributes['kode'])->first(); 
                return $bank->nama_bank;
            },
            'nama_rekening' => $this->faker->name,
            'nomor_rekening' => $this->faker->unique()->numberBetween(1000000000000, 9999999999999),
        ];
    }
}
