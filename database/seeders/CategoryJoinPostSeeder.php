<?php

namespace Database\Seeders;

use App\Models\CategoryJoinPost;
use Illuminate\Database\Seeder;

class CategoryJoinPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryJoinPost::factory()->count(10)->create();
    }
}
