<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->ulid,
            'title' => $this->title,
            'content' => $this->content,
            'author_name' => $this->author_name, 
            'category_id' => $this->category ? $this->category->id : null,
            'category_name' => $this->category ? $this->category->name : null,
            'image' => url('storage/'.$this->image),
        ];
    }
}
