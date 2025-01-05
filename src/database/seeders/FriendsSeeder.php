<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

final class FriendsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 100) as $i) {
            $user = User::query()->inRandomOrder()->first();
            $friends = User::query()->inRandomOrder()->limit(10)->get();

            $user->friends()->attach($friends);
            foreach ($friends as $friend) {
                $friend->friends()->attach($user);
            }
        }
    }
}
