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
        $min = $this->faker->numberBetween(10, 60); // Minimum cooking time
        $max = $min + $this->faker->numberBetween(5, 30); // Maximum cooking time, ensuring it's more than the min

        return [
            'uuid' => Str::uuid(),
            'title' => implode(' ', $this->faker->words(3)),
            'description' => $this->faker->paragraph,
            'instructions' => $this->faker->paragraphs(3, true),
            // 'image' => 'images/'.$this->faker->image('public/storage/images', 640, 480, null, false),
            'category_id' => \App\Models\Category::factory(), // Assuming Category factory exists
            'cooking_time' => "{$min}-{$max} mins",
            'author' => $this->faker->name,
        ];
    }
}
