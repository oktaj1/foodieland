<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {

        $blogPosts = BlogPost::paginate(20);

        return BlogPostResource::collection($blogPosts);
    }

    public function show($uuid)
    {
        // TODO: Use firstOrFail() instead of first()
        // and remove the if statement
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (! $blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }

        return new BlogPostResource($blogPost);
    }

    // TODO: use FormRequest class to validate request
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('postimages', 'public');
            $validatedData['image'] = $path;
        }

        // TODO: maybe rename the author field to author_id if we have logged users for this, or rename it to author_name
        $validatedData['author'] = auth()->user()->name;
        $validatedData['uuid'] = (string) Str::uuid();

        $blogPost = BlogPost::create($validatedData);

        return new BlogPostResource($blogPost);
    }

    // TODO: use FormRequest class to validate request
    // and use Model Binding
    public function update(Request $request, $uuid)
    {
        // TODO: use firstOrFail() instead of first()
        // and remove the if statement
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (! $blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image);
            }
            $path = $request->file('image')->store('postimages', 'public');
            $validatedData['image'] = $path;
        }

        $blogPost->update($validatedData);

        return new BlogPostResource($blogPost);
    }

    // TODO: use Model Binding
    // and use Database Transactions in case one of the queries fails
    public function destroy($uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (! $blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }

        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }

        $blogPost->delete();

        return response()->json(['message' => 'Blog Post Deleted Successfully']);
    }
}
