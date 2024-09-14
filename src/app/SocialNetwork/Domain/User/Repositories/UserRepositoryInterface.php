<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Repositories;

use App\SocialNetwork\Domain\User\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
}