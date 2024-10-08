<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate', ['--seed' => true]);

    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('creates a post successfully', function () {
    $topic = Topic::factory()->create();
    $this->user->syncRoles(['admin']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $topic->id,
        'user_id' => $this->user->id,
    ];

    $response = $this->postJson(route('v1.posts.store'), $postData);
    $response->assertStatus(201);
});

it('updates a post successfully', function () {
    $post = Post::factory()->create();
    $this->user->syncRoles(['admin']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $post->topic_id,
        'user_id' => $post->user_id,
    ];

    $response = $this->putJson(route('v1.posts.update', $post->id), $postData);
    $response->assertStatus(200);
});

it('deletes a post successfully', function () {
    $post = Post::factory()->create();
    $this->user->syncRoles(['admin']);

    $response = $this->deleteJson(route('v1.posts.destroy', $post->id));
    $response->assertStatus(200);
});

it('restores a post successfully', function () {
    $post = Post::factory()->create();
    $this->user->syncRoles(['admin']);

    $post->delete();

    $response = $this->postJson(route('v1.posts.restore'), ['id' => $post->id]);
    $response->assertStatus(200);
});

it('shows a post successfully', function () {
    $post = Post::factory()->create();

    $response = $this->getJson(route('v1.posts.show', $post->id));
    $response->assertStatus(200);
});

it('shows all posts successfully', function () {
    $response = $this->getJson(route('v1.posts.index'));
    $response->assertStatus(200);
});

it('fails to update a post without permission', function () {
    $post = Post::factory()->create();

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $post->topic_id,
        'user_id' => $post->user_id,
    ];

    $response = $this->putJson(route('v1.posts.update', $post->id), $postData);
    $response->assertStatus(403);
});

it('fails to delete a post without permission', function () {
    $post = Post::factory()->create();

    $response = $this->deleteJson(route('v1.posts.destroy', $post->id));
    $response->assertStatus(403);
});

it('create a post with writer role', function () {
    $topic = Topic::factory()->create();
    $this->user->syncRoles(['writer']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $topic->id,
        'user_id' => $this->user->id,
    ];

    $response = $this->postJson(route('v1.posts.store'), $postData);
    $response->assertStatus(201);
});

it('updates a post with writer role', function () {
    $post = Post::factory()->for($this->user)->create();
    $this->user->syncRoles(['writer']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $post->topic_id,
        'user_id' => $post->user_id,
    ];

    $response = $this->putJson(route('v1.posts.update', $post->id), $postData);
    $response->assertStatus(200);
});

it('deletes a post with writer role', function () {
    $post = Post::factory()->for($this->user)->create();
    $this->user->syncRoles(['writer']);

    $response = $this->deleteJson(route('v1.posts.destroy', $post->id));
    $response->assertStatus(200);
});

it('fails to create a post without permission', function () {
    $topic = Topic::factory()->create();

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $topic->id,
        'user_id' => $this->user->id,
    ];

    $response = $this->postJson(route('v1.posts.store'), $postData);
    $response->assertStatus(403);
});

it('fails to create a post with a non-existing topic', function () {
    $this->user->syncRoles(['admin']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => 999,
        'user_id' => $this->user->id,
    ];

    $response = $this->postJson(route('v1.posts.store'), $postData);
    $response->assertStatus(422);
});

it('fails to create a post with a non-existing user', function () {
    $topic = Topic::factory()->create();
    $this->user->syncRoles(['admin']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => $topic->id,
        'user_id' => 999,
    ];

    $response = $this->postJson(route('v1.posts.store'), $postData);
    $response->assertStatus(422);
});

it('fails to create a post with a non-existing user and topic', function () {
    $this->user->syncRoles(['admin']);

    $postData = [
        'title' => 'My first post',
        'body' => 'This is my first post',
        'topic_id' => 999,
        'user_id' => 999,
    ];

    $response = $this->postJson(route('v1.posts.store'), $postData);
    $response->assertStatus(422);
});
