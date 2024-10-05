<?php

namespace Database\Factories;

use App\Models\Posts;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostsFactory extends Factory
{
    protected $model = Posts::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'body' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'topic_id' => Topic::factory(),
            'user_id' => User::factory(),
        ];
    }
}
