<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBlogPostRequest;
use Illuminate\Support\Facades\DB;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::paginate(20);
        return BlogPostResource::collection($blogPosts);
    }

    public function show(BlogPost $blogPost)
    {
        
        return new BlogPostResource($blogPost);
    }

    public function store(StoreBlogPostRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('postimages', 'public');
            $validatedData['image'] = $path;
        }

        $validatedData['author_name'] = auth()->user()->name;
        $validatedData['ulid'] = (string) Str::ulid();

        $blogPost = BlogPost::create($validatedData);
        return new BlogPostResource($blogPost);
    }

    public function update(StoreBlogPostRequest $request, $ulid)
    {
        $blogPost = BlogPost::where('ulid', $ulid)->firstOrFail();

        $validatedData = $request->validated();

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

    public function destroy($ulid)
    {
        $blogPost = BlogPost::where('ulid', $ulid)->firstOrFail();

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
            return response()->json(['message' => 'An error occurred while deleting the blog post'], 500);
        }
    }
}
