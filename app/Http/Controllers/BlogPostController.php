<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
<<<<<<< HEAD
<<<<<<< HEAD
use Illuminate\Support\Str;
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD
use App\Http\Resources\BlogPostResource;
use App\Http\Requests\StoreBlogPostRequest;
=======
use Illuminate\Support\Str;
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

class BlogPostController extends Controller
{
    public function index()
    {

        $blogPosts = BlogPost::paginate(20);

        return BlogPostResource::collection($blogPosts);
    }

    public function show($uuid)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        $blogPost = BlogPost::where('uuid', $uuid)->firstOrFail();
        return new BlogPostResource($blogPost);
    }
    
    public function store(StoreBlogPostRequest $request)
    {
        $validatedData = $request->validated();
=======
        // TODO: Use firstOrFail() instead of first()
        // and remove the if statement
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (! $blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }

        return new BlogPostResource($blogPost);
    }
=======
        // TODO: Use firstOrFail() instead of first()
        // and remove the if statement
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (! $blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }

        return new BlogPostResource($blogPost);
    }
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

    // TODO: use FormRequest class to validate request
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
<<<<<<< HEAD
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('postimages', 'public');
            $validatedData['image'] = $path;
        }

<<<<<<< HEAD
<<<<<<< HEAD
        $validatedData['author_name '] = auth()->user()->name;
=======
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
        // TODO: maybe rename the author field to author_id if we have logged users for this, or rename it to author_name
        $validatedData['author'] = auth()->user()->name;
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
        $validatedData['uuid'] = (string) Str::uuid();

        $blogPost = BlogPost::create($validatedData);

        return new BlogPostResource($blogPost);
    }
<<<<<<< HEAD
<<<<<<< HEAD
    
    public function update(StoreBlogPostRequest $request, $uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->firstOrFail();
    
=======
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

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

<<<<<<< HEAD
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
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
<<<<<<< HEAD
<<<<<<< HEAD
    
    public function destroy(BlogPost $blogPost)
    {
        DB::beginTransaction();

        try {
=======
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

    // TODO: use Model Binding
    // and use Database Transactions in case one of the queries fails
    public function destroy($uuid)
    {
        $blogPost = BlogPost::where('uuid', $uuid)->first();
        if (! $blogPost) {
            return response()->json(['message' => 'Blog Post Not Found'], 404);
        }

<<<<<<< HEAD
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }

<<<<<<< HEAD
<<<<<<< HEAD

    
        $blogPost->delete();
    
        DB::commit();

        return response()->json(['message' => 'Blog Post Deleted Successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> 'an error occurred while deleting the blog post'], 500);
    }
}   

}
=======
        $blogPost->delete();
=======
        $blogPost->delete();
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

        return response()->json(['message' => 'Blog Post Deleted Successfully']);
    }
}
<<<<<<< HEAD
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
