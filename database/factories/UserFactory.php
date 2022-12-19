<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
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
            'phone' => $this->faker->unique()->phoneNumber(),
            'language' => $this->faker->randomElement(['uz', 'eng', 'ru']),
            'code' => $this->faker->numberBetween(1, 9999),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
