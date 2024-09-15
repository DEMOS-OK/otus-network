<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\Auth\DTO;

final class LoginUserDTO
{
    public function __construct(
        private string $email,
        private string $password,
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): LoginUserDTO
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): LoginUserDTO
    {
        $this->password = $password;

        return $this;
    }
}