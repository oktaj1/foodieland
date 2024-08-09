<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->ulid,
            'title' => $this->title,
            'cooking_time' => $this->cooking_time,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'image' => url('storage/'.$this->image),
            'category_name' => $this->category ? $this->category->name : null,
            'author_name' => $this->author_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}


