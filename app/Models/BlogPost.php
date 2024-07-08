<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    // Guard the category_id attribute
    protected $guarded = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
