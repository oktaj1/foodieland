<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Recipes
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);
Route::post('/recipes', [RecipeController::class, 'store']);
Route::put('/recipes/{id}', [RecipeController::class, 'update']);
Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);

// Blog Posts
Route::get('/blog-posts', [BlogPostController::class, 'index']);
Route::get('/blog-posts/{blogPost}', [BlogPostController::class, 'show']);
Route::post('/blog-posts', [BlogPostController::class, 'store']);
Route::put('/blog-posts/{blogPost}', [BlogPostController::class, 'update']);
Route::delete('/blog-posts/{blogPost}', [BlogPostController::class, 'destroy']);

// Categories

//TODO use model binding instead of id, example category param

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);

// Search
Route::get('/search', [SearchController::class, 'search']);

// Authentication
Route::post('/auth/logout', [AuthController::class, 'logout']);

// Ingredients
Route::get('/recipes/search', [RecipeController::class, 'searchByIngredient']);
