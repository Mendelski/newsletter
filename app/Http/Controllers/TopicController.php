<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Notifications\TopicFollowedNotification;
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

    public function restore(Topic $topic)
    {
        $this->authorize('restore', $topic);

        $topic->restore();

        return new TopicResource($topic);
    }

    public function follow(Topic $topic)
    {
        $this->authorize('follow', $topic);

        $topic->followers()->attach(auth()->id());
        auth()->user()->notify(new TopicFollowedNotification($topic));

        return response()->json();
    }

    public function unfollow(Topic $topic)
    {
        $this->authorize('unfollow', $topic);

        $topic->followers()->detach(auth()->id());

        return response()->json();
    }
}
