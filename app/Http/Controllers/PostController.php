<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Post::class);
        return PostsResource::collection(Post::all());
    }

    public function store(PostsRequest $request)
    {
        $this->authorize('create', Post::class);

        return new PostsResource(Post::create($request->validated()));
    }

    public function show(Post $posts)
    {
        $this->authorize('view', $posts);

        return new PostsResource($posts);
    }

    public function update(PostsRequest $request, Post $posts)
    {
        $this->authorize('update', $posts);

        $posts->update($request->validated());

        return new PostsResource($posts);
    }

    public function destroy(Post $posts)
    {
        $this->authorize('delete', $posts);

        $posts->delete();

        return response()->json();
    }

    public function restore(Post $posts)
    {
        $this->authorize('restore', $posts);

        $posts->restore();

        return new PostsResource($posts);
    }
}
