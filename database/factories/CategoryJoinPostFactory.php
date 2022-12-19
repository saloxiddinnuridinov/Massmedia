<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryJoinPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => PostCategory::all()->random()->id,
            'post_id' =>Post::all()->random()->id,
        ];
    }
}
