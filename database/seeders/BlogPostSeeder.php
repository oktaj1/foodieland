<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use App\Traits\hasulid;


class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BlogPost::factory()->count(3)->create();
    }
}
