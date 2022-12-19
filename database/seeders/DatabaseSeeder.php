<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([ 
            UserSeeder::class,
            SystemUserSeeder::class,
            PostCategorySeeder::class,
            QuestionCategorySeeder::class,
            PostSeeder::class,
            QuestionSeeder::class,
            FileSeeder::class,
            PostJoinFileSeeder::class,
            QuestionJoinFileSeeder::class,
            CategoryJoinPostSeeder::class,
            CategoryJoinQuestionSeeder::class,
       ]);
    }
}
