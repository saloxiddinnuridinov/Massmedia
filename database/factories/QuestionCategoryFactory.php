<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_uz' => $this->faker->name(),
            'name_ru' => $this->faker->lastName(),
            'name_eng' => $this->faker->name(),
        ];
    }
}
