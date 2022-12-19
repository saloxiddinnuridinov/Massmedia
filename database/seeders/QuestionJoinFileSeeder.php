<?php

namespace Database\Seeders;

use App\Models\QuestionJoinFile;
use Illuminate\Database\Seeder;

class QuestionJoinFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionJoinFile::factory()->count(10)->create();
    }
}
