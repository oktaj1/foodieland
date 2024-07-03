<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index()
    //TODO use Resource classes for this
    {
        $blogPosts = BlogPost::with('category')->paginate(20);

        return BlogPostResource::collection($blogPosts);
    }

    public function show(BlogPost $blogPost)
    {
        return new BlogPostResource($blogPost);
    }

    //TODO use Resource classes for this
    public function store(StoreBlogPostRequest $request)
    {
        $validatedData = $request->validated();
        $path = $request->file('image')->store('postimages', 'public');
        $validatedData['image'] = $path;

        $blogPost = BlogPost::create($validatedData);

        return new BlogPostResource($blogPost);
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    // TODO: use formrequest class for this
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image);
            }
            $path = $request->file('image')->store('postimages', 'public');
            $validatedData['image'] = $path;
        }
        //TODO use resource class

        $blogPost->update($validatedData);

        return new BlogPostResource($blogPost);
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }

        $blogPost->delete();

        return response()->json(['message' => 'Blog Post Deleted Successfully']);
    }
}
