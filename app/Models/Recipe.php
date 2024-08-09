<?php
namespace App\Models;

use App\Traits\hasulid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory, hasulid;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'instructions',
        'created_by',
        'image',
        'author_name',
        'ulid',
        'cooking_time'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe', 'recipe_id', 'ingredient_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}