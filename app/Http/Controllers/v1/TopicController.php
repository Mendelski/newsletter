<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Notifications\TopicFollowedNotification;
use App\Services\ApiReturnService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        return ApiReturnService::apiReturnSuccess([], 'Topic deleted successfully');
    }

    public function restore(Request $request)
    {
        $topic = Topic::withTrashed()->find($request->input('id'));

        $this->authorize('restore', Topic::class);

        $topic->restore();

        return new TopicResource($topic);
    }

    public function follow(Topic $topic): JsonResponse
    {
        $this->authorize('follow', Topic::class);

        $topic->followers()->attach(auth()->id());

        auth()->user()->notify(new TopicFollowedNotification($topic));

        return ApiReturnService::apiReturnSuccess([], 'Topic followed successfully');
    }

    public function unfollow(Topic $topic)
    {
        $this->authorize('unfollow', Topic::class);

        $topic->followers()->detach(auth()->id());

        return ApiReturnService::apiReturnSuccess([], 'Topic unfollowed successfully');
    }
}
