<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $id = $request->input('id');

        // Validate that id is present and is an integer
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the recipe and blog post by ID
        $recipe = Recipe::find($id);
        $blogPost = BlogPost::find($id);

        $results = [
            'recipe' => $recipe,
            'blogPost' => $blogPost,
        ];

        return response()->json($results);
    }
}
