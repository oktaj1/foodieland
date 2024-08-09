<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition()
    {
        return [
            'ulid' => Str::ulid(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            // 'image' => 'postimages/'.$this->faker->image('public/storage/postimages', 640, 480, null, false),
            'author_name' => $this->faker->name,
            'category_id' => \App\Models\Category::factory(), // Assuming Category factory exists
        ];
    }
}
