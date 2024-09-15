<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\Auth\Actions;

use App\SocialNetwork\Application\Auth\DTO\LoginUserDTO;
use App\SocialNetwork\Application\Auth\Exceptions\BadCredentialsException;
use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;

final readonly class LoginUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {

    }

    /**
     * @throws BadCredentialsException
     */
    public function __invoke(LoginUserDTO $dto): User
    {
        $user = $this->userRepository->findByEmail($dto->getEmail());

        if (!$user) {
            throw new BadCredentialsException();
        }

        if (!password_verify($dto->getPassword(), $user->getPassword())) {
            throw new BadCredentialsException();
        }

        return $user;
    }
}