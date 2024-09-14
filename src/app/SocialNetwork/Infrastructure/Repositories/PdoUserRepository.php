<?php

declare(strict_types=1);

namespace App\SocialNetwork\Infrastructure\Repositories;

use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use PDO;

final readonly class PdoUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private PDO $pdo,
    ) {
    }

    public function save(User $user): User
    {
        $query = "INSERT INTO users (name, email, password, email_verified_at) VALUES (:name, :email, :password, :email_verified_at)";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $user->getName());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':email_verified_at', $user->getEmailVerifiedAt());
        $stmt->execute();

        $userId = $this->pdo->lastInsertId();

        $user->setId((int) $userId);

        $query = "INSERT INTO user_infos (firstname, lastname, date_of_birth, gender, about, city, user_id)
              VALUES (:firstname, :lastname, :dateOfBirth, :gender, :about, :city, :userId)";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':firstname', $user->getInfo()->getName());
        $stmt->bindValue(':lastname', $user->getInfo()->getLastname());
        $stmt->bindValue(':dateOfBirth', $user->getInfo()->getDateOfBirth());
        $stmt->bindValue(':gender', $user->getInfo()->getGender()->value);
        $stmt->bindValue(':about', $user->getInfo()->getAbout());
        $stmt->bindValue(':city', $user->getInfo()->getCity());
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $user->getInfo()->setId((int) $this->pdo->lastInsertId());

        return $user;
    }
}