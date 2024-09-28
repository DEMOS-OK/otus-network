<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

final class UserInfoFactory extends Factory
{
    protected $model = UserInfo::class;

    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'date_of_birth' => $this->faker->date,
            'gender' => $this->faker->randomElement([1, 2]),
            'about' => $this->faker->sentence,
            'city' => $this->faker->city,
        ];
    }
}