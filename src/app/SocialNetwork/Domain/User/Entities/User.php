<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Entities;

final class User extends Entity
{
    private int $id;

    private string $name;

    private string $email;

    private ?string $email_verified_at;

    private string $password;

    private ?string $remember_token;

    private UserInfo $info;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'info' => $this->info->toArray(),
        ];
    }
}