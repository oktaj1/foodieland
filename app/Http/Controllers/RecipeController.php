<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category')->paginate(20);

        return RecipeResource::collection($recipes);
    }

    // Use model binding instead of uuid
    public function show(Recipe $recipe)
    {
        $recipe->load('category');

        return new RecipeResource($recipe);
    }

    public function store(StoreRecipeRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        // TODO: The database column should also be changed to author_name
        // TODO: also there's an error when running seeders because the author_name is not set in the database table recipes
        $validatedData['author_name'] = auth()->user()->name; // Store author's name
        $validatedData['uuid'] = (string) Str::uuid();

        $recipe = Recipe::create($validatedData);

        return new RecipeResource($recipe);
    }

    public function update(StoreRecipeRequest $request, Recipe $recipe)
    {
        $validatedData = $request->validated();

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

    public function destroy(Recipe $recipe)
    {
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return response()->json(['message' => 'Recipe Deleted Successfully']);
    }
}
