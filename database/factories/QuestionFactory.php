<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'user_id' => User::all()->random()->id,
            'content' => $this->faker->name(),
            'image' => $this->faker->url(),
        ];
    }
}
