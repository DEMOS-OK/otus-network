<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\SocialNetwork\Infrastructure\Repositories\Eloquent\Models\Post;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(20)->create();
        $this->call(FriendsSeeder::class);

        for ($i = 0; $i < 10; $i++) {
            Post::factory()->count(2000)->create();
        }
    }
}