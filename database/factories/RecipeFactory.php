<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'instructions' => $this->faker->paragraphs(3, true),
            'image' => 'images/'.$this->faker->image('public/storage/images', 640, 480, null, false),
            'category_id' => \App\Models\Category::factory(), // Assuming Category factory exists
        ];
    }
}
