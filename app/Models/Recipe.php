<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
