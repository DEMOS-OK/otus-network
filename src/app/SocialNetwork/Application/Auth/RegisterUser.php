<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\Auth;

use App\SocialNetwork\Application\Auth\DTO\RegisterUserDTO;
use App\SocialNetwork\Application\Auth\Exceptions\InvalidPasswordConfirmationException;
use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Entities\UserInfo;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use Carbon\Carbon;

final readonly class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @throws InvalidPasswordConfirmationException
     */
    public function __invoke(RegisterUserDTO $dto): User
    {
        if ($dto->getPassword() !== $dto->getPasswordConfirmation()) {
            throw new InvalidPasswordConfirmationException();
        }

        $user = User::make()
            ->setName($dto->getFirstname() . $dto->getLastname())
            ->setPassword($dto->getPassword())
            ->setEmailVerifiedAt(Carbon::now()->format("Y-m-d H:i:s"))
            ->setEmail($dto->getEmail())
            ->setInfo(
                UserInfo::make()
                    ->setName($dto->getFirstname())
                    ->setLastname($dto->getLastname())
                    ->setGender($dto->getGender())
                    ->setAbout($dto->getAbout())
                    ->setCity($dto->getCity())
                    ->setDateOfBirth($dto->getDateOfBirth())
            );

        return $this->userRepository->save($user);
    }
}