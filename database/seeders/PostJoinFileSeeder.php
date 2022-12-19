<?php

namespace Database\Seeders;

use App\Models\PostJoinFile;
use Illuminate\Database\Seeder;

class PostJoinFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostJoinFile::factory()->count(10)->create();
    }
}
