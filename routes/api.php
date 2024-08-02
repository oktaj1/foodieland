<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\SetCookieTokenInHeaders;
use App\Http\Controllers\Auth\ForgotEmailController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;



// Authentication (public routes)
Route::post('/register', RegisterUserController::class);
Route::post('/login', LoginController::class)->name('login');

// Email Verification
Route::post('register', [RegisterUserController::class, '__invoke']);
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify')
    ->middleware(['signed', 'throttle:6,1']);

// Forgot Email
Route::post('email/forgot', [ForgotEmailController::class, 'sendEmailInfo']);


// Forgot Password
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

// Most Viewed Recipes
Route::get('/recipes/most-viewed', [RecipeController::class, 'mostViewed']);

// Recipes (public routes)
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{uuid}', [RecipeController::class, 'show']);

//Posts (public routes)
Route::get('/posts', [BlogPostController::class, 'index']);
Route::get('/posts/{uuid}', [BlogPostController::class, 'show']);

// Categories (public routes)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

// Protected routes
Route::middleware(['setCookieTokenInHeaders', 'auth:sanctum'])->group(function () {
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{uuid}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{uuid}', [RecipeController::class, 'destroy']);
    

    // Blog Posts
    Route::post('/blog-posts', [BlogPostController::class, 'store']);
    Route::put('/blog-posts/{uuid}', [BlogPostController::class, 'update']);
    Route::delete('/blog-posts/{uuid}', [BlogPostController::class, 'destroy']);

    // Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{uuid}', [CategoryController::class, 'update']);
});


// Search
Route::get('/search', [SearchController::class, 'search']);


// Contact
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/contact', [ContactController::class, 'index']);