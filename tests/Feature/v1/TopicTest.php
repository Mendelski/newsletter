<?php

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->artisan('migrate', ['--seed' => true]);
    $this->user = User::factory()->create();
    $this->user->syncRoles(['admin']);

    $this->actingAs($this->user);
});

uses(RefreshDatabase::class);

it('creates a topic successfully', function () {
    $topicData = [
        'name' => 'My first topic',
        'slug' => 'my-first-topic',
        'description' => 'This is my first topic',
    ];

    $response = $this->postJson(route('v1.topics.store'), $topicData);
    $response->assertStatus(201);
});

it('updates a topic successfully', function () {
    $topic = Topic::factory()->create();

    $topicData = [
        'name' => 'My first topic',
        'slug' => 'my-first-topic',
        'description' => 'This is my first topic',
    ];

    $response = $this->putJson(route('v1.topics.update', $topic->id), $topicData);
    $response->assertStatus(200);
});

it('deletes a topic successfully', function () {
    $topic = Topic::factory()->create();

    $response = $this->deleteJson(route('v1.topics.destroy', $topic->id));
    $response->assertStatus(200);
});

it('restores a topic successfully', function () {
    $topic = Topic::factory()->create();
    $topic->delete();

    $response = $this->postJson(route('v1.topics.restore', ['id' => $topic->id]));
    $response->assertStatus(200);
});

it('should subscribe to a topic successfully', function () {
    $topic = Topic::factory()->create();
    $this->user->syncRoles(['user']);

    $response = $this->getJson(route('v1.topics.follow', $topic->id));
    $response->assertStatus(200);

    $this->assertDatabaseHas('subscriptions', [
        'user_id' => $this->user->id,
        'topic_id' => $topic->id,
    ]);
});

it('should unsubscribe from a topic successfully', function () {
    $topic = Topic::factory()->create();
    $this->user->syncRoles(['user']);

    $this->getJson(route('v1.topics.follow', $topic->id));

    $response = $this->getJson(route('v1.topics.unfollow', $topic->id));
    $response->assertStatus(200);

    $this->assertDatabaseMissing('subscriptions', [
        'user_id' => $this->user->id,
        'topic_id' => $topic->id,
    ]);
});
