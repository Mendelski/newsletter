<?php

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class);
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate', ['--seed' => true]);
});

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('should login', function () {
    User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $credentials = [
        'email' => 'john@example.com',
        'password' => 'password',
    ];

    $token = AuthService::login($credentials);

    expect($token)->toBeString();
});

it('should not login with invalid credentials', function () {
    User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $credentials = [
        'email' => 'wrongJohn@example.com',
        'password' => 'password',
    ];

    $token = AuthService::login($credentials);
    expect($token)->toBeNull();
});

//make a test for the register method
it('should register', function () {
    $credentials = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ];
    $token = AuthService::register($credentials);
    expect($token)->toBeString();
});

it('should check if user is admin', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $isAdmin = AuthService::isAdmin($user);
    expect($isAdmin)->toBeTrue();
});

it('should change user role', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $roles = ['user'];
    $user = AuthService::changeRole($user->id, $roles);
    expect($user['roles'])->toBe($roles);
});
