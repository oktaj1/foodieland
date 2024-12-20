<?php

// app/Models/Ingredient.php

namespace App\Models;

use App\Traits\hasulid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    use hasulid;

    protected $guarded = [];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
