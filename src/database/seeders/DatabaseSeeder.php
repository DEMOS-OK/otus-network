<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 5000; $i++) {
            User::factory()->count(200)->create();
        }
    }
}