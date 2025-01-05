<?php

declare(strict_types=1);

namespace Database\Factories\SocialNetwork\Infrastructure\Repositories\Eloquent\Models;

use App\Models\User;
use App\SocialNetwork\Infrastructure\Repositories\Eloquent\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'published_at' => $this->faker->dateTime,
        ];
    }
}