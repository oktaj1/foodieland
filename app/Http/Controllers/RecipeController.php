<?php
namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RecipeResource;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category')->paginate(20);
        return RecipeResource::collection($recipes);
    }

    public function show($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->first();
    
        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not Found'], 404);
        }
    

        $recipe->views += 1;
        $recipe->save();
    
        return new RecipeResource($recipe);
    }
    
    public function mostViewed()
    {
        Log::info('mostViewed method called');
    
        try {
            // First, let's get all recipes and their view counts
            $allRecipes = Recipe::select('id', 'title', 'views')->get();
            Log::info('All recipes:', $allRecipes->toArray());
    
            // Now, let's get the top 3 as before
            $topRecipes = Recipe::orderBy('views', 'desc')->take(3)->get();
            Log::info('Top 3 recipes:', $topRecipes->toArray());
    
            if ($topRecipes->isEmpty()) {
                Log::info('No recipes found with views');
                return response()->json(['message' => 'No recipes found with views'], 404);
            }
    
            Log::info('Returning top recipes');
            return RecipeResource::collection($topRecipes);
        } catch (\Exception $e) {
            Log::error('Error in mostViewed method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
    

    public function store(Request $request)
    {
        Log::info('Authenticated User:', ['user' => auth()->user()]);
    
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'cooking_time' => 'required|string|max:255',
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }
    
        $validatedData['author'] = auth()->user()->name; // Set the author to the authenticated user's name
        $validatedData['uuid'] = (string) Str::uuid();  // Assuming you want to generate a UUID for each recipe
    
        $recipe = Recipe::create($validatedData);
    
        return new RecipeResource($recipe);
    }

    public function update(Request $request, $uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->first();

        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not
             Found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'cooking_time' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $recipe->update($validatedData);

        return new RecipeResource($recipe);
    }

    public function destroy($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->first();

        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not Found'], 404);
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return response()->json(['message' => 'Recipe Deleted Successfully']);
    }
}
