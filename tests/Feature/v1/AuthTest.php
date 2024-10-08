<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate', ['--seed' => true]);
});

it('registers a user successfully', function () {
    $response = $this->postJson(route('v1.register'), [
        'name' => User::factory()->make()->name,
        'email' => User::factory()->make()->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => ['token'],
            'error',
        ])->assertJson([
            'message' => 'Success',
            'error' => false,
        ]);
});

it('fails to register a user with missing fields', function () {
    $response = $this->postJson(route('v1.register'), [
        'name' => '',
        'email' => '',
        'password' => '',
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'name' => [],
                'email' => [],
                'password' => [],
            ],
        ]);
});

it('logs in a user successfully', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->postJson(route('v1.login'), [
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => ['token'],
            'error',
        ])->assertJson([
            'message' => 'Success',
            'error' => false,
        ]);
});

it('fails to log in with invalid credentials', function () {
    $response = $this->postJson(route('v1.login'), [
        'email' => 'nonexistent@example.com',
        'password' => 'invalidpassword',
    ]);

    $response->assertStatus(401)
        ->assertJsonStructure([
            'message',
            'error',
        ])->assertJson([
            'message' => 'Invalid credentials',
            'error' => true,
        ]);
});

it('logs out a user successfully', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson(route('v1.logout'));

    $response->assertStatus(204);
});

it('changes role successfully', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(['admin']);
    $this->actingAs($admin);

    $user = User::factory()->create();
    $response = $this->postJson(route('v1.changeRole'), [
        'user_id' => $user->id,
        'roles' => ['admin'],
    ]);

    expect($user->hasRole('admin'))->toBeTrue();
    $response->assertStatus(200);
});

it('returns unauthorized when changing role without authentication', function () {
    $response = $this->postJson(route('v1.changeRole'), [
        'user_id' => 1,
        'role' => 'admin',
    ]);

    $response->assertStatus(401);
});

it('returns validation error for invalid role', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson(route('v1.changeRole'), [
        'user_id' => $user->id,
        'roles' => ['invalid_role'],
    ]);

    $response->assertStatus(400);
});
