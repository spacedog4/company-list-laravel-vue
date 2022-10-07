<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city_id' => City::inRandomOrder()->first()->id,
            'name' => fake()->company,
            'description' => fake()->sentence(20),
            'email' => fake()->email,
            'phone' => fake()->phoneNumber
        ];
    }
}
