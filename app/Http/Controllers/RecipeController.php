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

        return new RecipeResource($recipe);
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
            return response()->json(['message' => 'Recipe Not Found'], 404);
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
