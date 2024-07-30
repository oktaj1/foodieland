<?php
namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Http\Resources\BlogPostResource;
use App\Models\Recipe;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Validate the query input
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Search recipes
        $recipes = Recipe::where('title', 'like', '%' . $query . '%')
                         ->orWhere('description', 'like', '%' . $query . '%')
                         ->orWhere('author', 'like', '%' . $query . '%')
                         ->get();

        // Search blog posts
        $blogPosts = BlogPost::where('title', 'like', '%' . $query . '%')
                              ->orWhere('content', 'like', '%' . $query . '%')
                              ->orWhere('author', 'like', '%' . $query . '%')
                              ->get();

        $results = [
            'recipes' => RecipeResource::collection($recipes),
            'blogPosts' => BlogPostResource::collection($blogPosts),
        ];

        return response()->json($results);
    }
}

