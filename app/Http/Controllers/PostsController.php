<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Http\Resources\PostsResource;
use App\Models\Posts;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Posts::class);

        return PostsResource::collection(Posts::all());
    }

    public function store(PostsRequest $request)
    {
        $this->authorize('create', Posts::class);

        return new PostsResource(Posts::create($request->validated()));
    }

    public function show(Posts $posts)
    {
        $this->authorize('view', $posts);

        return new PostsResource($posts);
    }

    public function update(PostsRequest $request, Posts $posts)
    {
        $this->authorize('update', $posts);

        $posts->update($request->validated());

        return new PostsResource($posts);
    }

    public function destroy(Posts $posts)
    {
        $this->authorize('delete', $posts);

        $posts->delete();

        return response()->json();
    }
}
