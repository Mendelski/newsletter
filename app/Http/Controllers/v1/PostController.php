<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return new PostsResource($post);
    }

    public function update(PostsRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return new PostsResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', Post::class);

        $post->delete();

        return response()->json();
    }

    public function restore(Request $request)
    {
        $this->authorize('restore', Post::class);

        $posts = Post::withTrashed()->find($request->input('id'));
        $posts->restore();

        return new PostsResource($posts);
    }
}
