<?php

use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Auth\PermissionController;
use App\Http\Controllers\v1\PostController;
use App\Http\Controllers\v1\TopicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-role', [PermissionController::class, 'changeRole']);

    Route::controller(PostController::class)->group(function () {
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'index')->name('posts.index');
            Route::post('/', 'store')->name('posts.store');
            Route::get('/{posts}', 'show')->name('posts.show');
            Route::put('/{posts}', 'update')->name('posts.update');
            Route::delete('/{posts}', 'destroy')->name('posts.destroy');
            Route::post('/restore', 'restore')->name('posts.restore');
        });
    });

    Route::controller(TopicController::class)->group(function () {
        Route::group(['prefix' => 'topics'], function () {
            Route::get('/', 'index')->name('topics.index');
            Route::post('/', 'store')->name('topics.store');
            Route::get('/{topics}', 'show')->name('topics.show');
            Route::put('/{topics}', 'update')->name('topics.update');
            Route::delete('/{topics}', 'destroy')->name('topics.destroy');
            Route::post('/restore', 'restore')->name('topics.restore');
            Route::get('/{topics}/follow', 'follow')->name('topics.follow');
            Route::get('/{topics}/unfollow', 'unfollow')->name('topics.unfollow');
        });
    });
});
