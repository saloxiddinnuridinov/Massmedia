<?php

namespace Database\Seeders;

use App\Models\CategoryJoinQuestion;
use Illuminate\Database\Seeder;

class CategoryJoinQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryJoinQuestion::factory()->count(10)->create();
    }
}
