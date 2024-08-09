<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'image' => 'required|image|max:2048',

            // TODO: the frontend only has access to the uuid not the id, so we need to change this

            'category_id' => 'required|exists:categories,id',

            // 'category_id' => 'required|exists:categories,uuid',

            'category_id' => 'required|exists:categories,uuid',


        ];
    }
}
