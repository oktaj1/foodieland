<?php

// app/Models/Ingredient.php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
