<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $recipes = Recipe::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('ingredients', 'like', "%{$query}%")
            ->get();

        $blogPosts = BlogPost::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get();

        $results = [
            'recipes' => $recipes,
            'blogPosts' => $blogPosts,
        ];

        return response()->json($results);
    }
}
