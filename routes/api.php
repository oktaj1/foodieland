<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Authentication (public routes)
Route::post('/register', RegisterUserController::class);
Route::post('/login', LoginController::class);

// Recipes
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{uuid}', [RecipeController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{uuid}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{uuid}', [RecipeController::class, 'destroy']);

    // Blog Posts
    Route::post('/blog-posts', [BlogPostController::class, 'store']);
    Route::put('/blog-posts/{uuid}', [BlogPostController::class, 'update']);
    Route::delete('/blog-posts/{uuid}', [BlogPostController::class, 'destroy']);

    // Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
});
