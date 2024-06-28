<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::select('id', 'title', 'description', 'instructions', 'image', 'category_id', 'ingredients')
            ->get();

        $recipes = $recipes->map(function ($recipe) {
            $recipe->category_name = Category::find($recipe->category_id)->name;
            $recipe->image = url('storage/'.$recipe->image);
            unset($recipe->category_id);

            return $recipe->makeHidden(['created_at', 'updated_at']);
        });

        return response()->json($recipes);
    }

    public function show($id)
    {
        $recipe = Recipe::select('id', 'title', 'description', 'instructions', 'image', 'category_id', 'ingredients')
            ->find($id);

        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not Found'], 404);
        }

        $recipe->category_name = Category::find($recipe->category_id)->name;
        $recipe->image = url('storage/'.$recipe->image);
        unset($recipe->category_id);

        return response()->json($recipe->makeHidden(['created_at', 'updated_at']));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $recipe = Recipe::create($validatedData);

        $recipe->category_name = Category::find($recipe->category_id)->name;
        $recipe->image = url('storage/'.$recipe->image);
        unset($recipe->category_id);

        return response()->json($recipe->makeHidden(['created_at', 'updated_at']), 201);
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not Found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $recipe->update($validatedData);

        $recipe->category_name = Category::find($recipe->category_id)->name;
        $recipe->image = url('storage/'.$recipe->image);
        unset($recipe->category_id);

        return response()->json($recipe->makeHidden(['created_at', 'updated_at']));
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not Found'], 404);
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return response()->json(['message' => 'Recipe Deleted Successfully']);
    }

    public function searchByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');

        $request->validate([
            'ingredient' => 'required|string|min:1',
        ]);

        $recipes = Recipe::where('ingredients', 'like', "%{$ingredient}%")
            ->select('title', 'description', 'instructions', 'image', 'category_id', 'ingredients')
            ->get();

        $recipes = $recipes->map(function ($recipe) {
            $recipe->category_name = Category::find($recipe->category_id)->name;
            $recipe->image = url('storage/'.$recipe->image);
            unset($recipe->category_id);

            return $recipe->makeHidden(['created_at', 'updated_at']);
        });

        return response()->json($recipes);
    }
}
