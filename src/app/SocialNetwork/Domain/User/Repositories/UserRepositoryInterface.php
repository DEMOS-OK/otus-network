<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Repositories;

use App\SocialNetwork\Domain\User\Entities\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    /**
     * @return Collection<User>
     */
    public function findByInitials(string $firstname, string $lastname): Collection;
}