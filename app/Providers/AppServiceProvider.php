<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Topic;
use App\Policies\PostPolicy;
use App\Policies\TopicPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $policies = [
        Post::class => PostPolicy::class,
        Topic::class => TopicPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
