<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BlogPostResource;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::paginate(20);
        return BlogPostResource::collection($blogPosts);
    }

    public function show($uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (!$blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }
        return new BlogPostResource($blogPost);
    }
    
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
    
        $validatedData['author'] = auth()->user()->name;
        $validatedData['uuid'] = (string) Str::uuid();
    
        $blogPost = BlogPost::create($validatedData);
    
        return new BlogPostResource($blogPost);
    }
    
    public function update(Request $request, $uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (!$blogPost) {
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
    
    public function destroy($uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (!$blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }
    
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }
    
        $blogPost->delete();
    
        return response()->json(['message' => 'Blog Post Deleted Successfully']);
    }
}   