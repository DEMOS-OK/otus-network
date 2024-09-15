<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\User\Actions;

use App\SocialNetwork\Application\Auth\Exceptions\UserNotFoundException;
use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;

final readonly class FindUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(int $id): User
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}