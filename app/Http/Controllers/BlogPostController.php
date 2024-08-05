<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BlogPostResource;
use App\Http\Requests\StoreBlogPostRequest;

class BlogPostController extends Controller
{   
    public function index()
    {
        
        $blogPosts = BlogPost::paginate(20);
        return BlogPostResource::collection($blogPosts);
    }

    public function show($uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->firstOrFail();
        return new BlogPostResource($blogPost);
    }
    
    public function store(StoreBlogPostRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('postimages', 'public');
            $validatedData['image'] = $path;
        }

        $validatedData['author_name '] = auth()->user()->name;
        $validatedData['uuid'] = (string) Str::uuid();

        $blogPost = BlogPost::create($validatedData);

        return new BlogPostResource($blogPost);
    }
    
    public function update(StoreBlogPostRequest $request, $uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->firstOrFail();
    
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
    
    public function destroy(BlogPost $blogPost)
    {
        DB::beginTransaction();

        try {
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }


    
        $blogPost->delete();
    
        DB::commit();

        return response()->json(['message' => 'Blog Post Deleted Successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> 'an error occurred while deleting the blog post'], 500);
    }
}   

}