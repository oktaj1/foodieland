<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\RecipeResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRecipeRequest;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category')->paginate(20);

        return RecipeResource::collection($recipes);
    }

    // TODO: use model binding instead of uuid
    public function show($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->with('category')->firstOrFail();

        return new RecipeResource($recipe);
    }

<<<<<<< HEAD
    public function store(StoreRecipeRequest $request)
=======
    // TODO: use FormRequest to validate the request
    public function store(Request $request)
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $validatedData['author_name'] = auth()->user()->name; // Store author's name
        $validatedData['uuid'] = (string) Str::uuid();

        $recipe = Recipe::create($validatedData);

        return new RecipeResource($recipe);
    }

    public function update(StoreRecipeRequest $request, $uuid)
    {
<<<<<<< HEAD
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
=======
        // TODO: use firstOrFail instead of first() and remove the if statement
        $recipe = Recipe::where('uuid', $uuid)->first();
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

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

    // TODO: use Model Binding
    public function destroy($uuid)
    {
<<<<<<< HEAD
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
=======
        // TODO: use firstOrFail instead of first() and remove the if statement
        $recipe = Recipe::where('uuid', $uuid)->first();

        if (! $recipe) {
            return response()->json(['message' => 'Recipe Not Found'], 404);
        }
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return response()->json(['message' => 'Recipe Deleted Successfully']);
    }
}
