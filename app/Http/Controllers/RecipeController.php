<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Requests\StoreRecipeRequest;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreRecipeRequest;
use Illuminate\Support\Facades\Validator;
=======
use Illuminate\Support\Str;


class RecipeController extends Controller
{

    
    // Predefined list of common ingredients
    private $commonIngredients = [
        'flour', 'sugar', 'salt', 'butter', 'milk', 'egg', 'water', 
        'oil', 'pepper', 'onion', 'garlic', 'tomato', 'chicken', 'beef',
        // Add more common ingredients here
    ];
    


    public function index()
    {
        $recipes = Recipe::with('category')->paginate(20);

        return RecipeResource::collection($recipes);
    }

    // Use model binding instead of ulid
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
        $validatedData['ulid'] = (string) Str::ulid();
    
        // Create the Recipe
        $recipe = Recipe::create($validatedData);
    
        // Process Ingredients
        $ingredients = $request->input('ingredients', []); // assuming ingredients are passed as an array
        $ingredientIds = [];
    
        foreach ($ingredients as $ingredientName) {
            // Check if the ingredient already exists
            $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
    
            // Store the ingredient's ID for the pivot table
            $ingredientIds[] = $ingredient->id;
        }
    
        // Attach ingredients to the recipe
        $recipe->ingredients()->sync($ingredientIds);
    
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

    private function extractIngredients($description)
    {
        $description = strtolower($description);
        $foundIngredients = [];

        foreach ($this->commonIngredients as $ingredient) {
            if (strpos($description, $ingredient) !== false) {
                $foundIngredients[] = $ingredient;
            }
        }

        return $foundIngredients;
    }

}
