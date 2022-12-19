<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SystemUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'middlename' => $this->faker->name(),
            'surname' => $this->faker->LastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('admin123'),
            'phone' => $this->faker->unique()->phoneNumber(),
            'language' => $this->faker->randomElement(['uz', 'eng', 'ru']),
            'remember_token' => Str::random(10),
        ];
    }
}
