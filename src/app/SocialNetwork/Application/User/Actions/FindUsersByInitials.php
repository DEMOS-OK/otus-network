<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\User\Actions;

use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

final readonly class FindUsersByInitials
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @return Collection<User>
     */
    public function __invoke(string $firstname, string $lastname): Collection
    {
        return $this->userRepository->findByInitials($firstname, $lastname);
    }
}