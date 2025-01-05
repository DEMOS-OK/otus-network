<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\User\Actions;

use App\SocialNetwork\Application\Auth\Exceptions\UserNotFoundException;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;

final readonly class AddFriend
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private FindUser $findUser,
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(int $userId, int $friendId): void
    {
        $user = ($this->findUser)($userId);
        $friend = ($this->findUser)($friendId);

        $user->addFriend($friend);
        $this->userRepository->save($user);

        $friend->addFriend($user);
        $this->userRepository->save($friend);
    }
}