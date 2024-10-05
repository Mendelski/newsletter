<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TopicController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Topic::class);

        return TopicResource::collection(Topic::all());
    }

    public function store(TopicRequest $request)
    {
        $this->authorize('create', Topic::class);

        return new TopicResource(Topic::create($request->validated()));
    }

    public function show(Topic $topic)
    {
        $this->authorize('view', $topic);

        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->update($request->validated());

        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('delete', $topic);

        $topic->delete();

        return response()->json();
    }
}
