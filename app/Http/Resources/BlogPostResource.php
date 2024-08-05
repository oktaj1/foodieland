<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'content' => $this->content,
<<<<<<< HEAD
            'author_name' => $this->author_name,
=======
            'author' => $this->author,
            // TODO: instead of direclty returnning the category here, better is to return a categoryResource
            // and even then dont return the id, but the uuid like this: 'id' => $this->uuid
<<<<<<< HEAD
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
            'category_id' => $this->category ? $this->category->id : null,
            'category_name' => $this->category ? $this->category->name : null,
            'image' => url('storage/'.$this->image),
        ];
    }
}
