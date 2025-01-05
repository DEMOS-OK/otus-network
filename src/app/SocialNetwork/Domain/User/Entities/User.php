<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Entities;

final class User extends Entity
{
    private ?int $id = null;

    private string $name;

    private string $email;

    private ?string $email_verified_at;

    private string $password;

    private ?string $remember_token;

    private ?UserInfo $info = null;

    /**
     * @var array<User>
     */
    private array $friends;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?string $email_verified_at): self
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    public function setRememberToken(?string $rememberToken): self
    {
        $this->remember_token = $rememberToken;

        return $this;
    }

    public function getInfo(): UserInfo
    {
        return $this->info;
    }

    public function setInfo(UserInfo $info): User
    {
        $this->info = $info;

        return $this;
    }

    public function getFriends(): array
    {
        return $this->friends;
    }

    public function setFriends(array $friends): self
    {
        $this->friends = $friends;

        return $this;
    }

    public function addFriend(User $friend): self
    {
        $this->friends[] = $friend;

        return $this;
    }

    public function removeFriend(User $friend): self
    {
        $this->friends = array_filter($this->friends, static fn(User $f) => $f->getId() !== $friend->getId());

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'info' => $this->info?->toArray(),
        ];
    }
}