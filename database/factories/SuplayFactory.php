<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suplay>
 */
class SuplayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = FakerFactory::create('id_ID');
        return [
            'nama' => $faker->name,
            'no_hp' => $faker->phoneNumber,
            'alamat' => $faker->address,
        ];
    }
}
