<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'title' => 'required',
            'description' => 'required',
            // 'image' => 'required|image',
            'ingredients' => 'array',
=======
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            // TODO: the frontend only has access to the uuid not the id, so we need to change this to uuid in the rules part

            'category_id' => 'required|exists:categories,id',
            'instructions' => 'required',
            'cooking_time' => 'required',
        ];
    }
}
