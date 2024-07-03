<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
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
