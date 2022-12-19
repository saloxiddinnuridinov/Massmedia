<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryJoinQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => QuestionCategory::all()->random()->id,
            'question_id' =>Question::all()->random()->id,
        ];
    }
}
