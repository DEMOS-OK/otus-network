<?php

declare(strict_types=1);

namespace App\SocialNetwork\Infrastructure\Repositories;

use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Entities\UserInfo;
use App\SocialNetwork\Domain\User\Enums\GenderEnum;
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

    public function findById(int $id): ?User
    {
        $query = "SELECT u.*, ui.id as user_info_id, ui.firstname, ui.lastname, 
                         ui.date_of_birth, ui.gender, ui.about, ui.city 
                  FROM users u
                  JOIN user_infos ui ON u.id = ui.user_id
                  WHERE u.id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data === false) {
            return null;
        }

        return $this->mapArrayToEntity($data);
    }

    public function findByEmail(string $email): ?User
    {
        $query = "SELECT u.*, ui.id as user_info_id, ui.firstname, ui.lastname, 
                         ui.date_of_birth, ui.gender, ui.about, ui.city 
                  FROM users u
                  JOIN user_infos ui ON u.id = ui.user_id
                  WHERE u.email = :email";


        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data === false) {
            return null;
        }

        return $this->mapArrayToEntity($data);
    }

    private function mapArrayToEntity(array $data): User
    {
        $user = User::make()
            ->setName($data['name'])
            ->setPassword($data['password'])
            ->setEmailVerifiedAt($data['email_verified_at'])
            ->setEmail($data['email'])
            ->setInfo(
                UserInfo::make()
                    ->setName($data['firstname'])
                    ->setLastname($data['lastname'])
                    ->setGender(GenderEnum::from($data['gender']))
                    ->setAbout($data['about'])
                    ->setCity($data['city'])
                    ->setDateOfBirth($data['date_of_birth'])
            );

        $user->setId((int) $data['id']);
        $user->getInfo()->setId((int) $data['user_info_id']);

        return $user;
    }
}