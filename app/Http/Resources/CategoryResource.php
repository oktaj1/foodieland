<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'image' => url('storage/'.$this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]; 
    }   
}
