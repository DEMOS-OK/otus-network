<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Repositories;

use App\SocialNetwork\Domain\User\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;
}