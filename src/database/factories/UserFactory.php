<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => substr(md5((string) random_int(100000000, 999999999)), 0, 6) . substr(md5((string) random_int(100000000, 999999999)), 0, 20) . '@gmail.com',
            'email_verified_at' => now(),
            'password' => self::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): self
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure(): Factory|self
    {
        return $this->afterCreating(function (User $user) {
            $user->info()->save(UserInfo::factory()->make());
        });
    }
}
