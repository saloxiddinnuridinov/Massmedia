<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionJoinFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_id' => Question::all()->random()->id,
            'file_id' => File::all()->random()->id,
        ];
    }
}
