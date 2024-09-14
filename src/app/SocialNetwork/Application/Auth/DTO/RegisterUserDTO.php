<?php

declare(strict_types=1);

namespace App\SocialNetwork\Application\Auth\DTO;

use App\SocialNetwork\Domain\User\Enums\GenderEnum;

final class RegisterUserDTO
{
    public function __construct(
        private string $firstname,
        private string $lastname,
        private string $dateOfBirth,
        private GenderEnum $gender,
        private string $about,
        private string $city,
        private string $email,
        private string $password,
        private string $passwordConfirmation,
    ) {
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): RegisterUserDTO
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): RegisterUserDTO
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth): RegisterUserDTO
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): RegisterUserDTO
    {
        $this->gender = $gender;
        return $this;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setAbout(string $about): RegisterUserDTO
    {
        $this->about = $about;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): RegisterUserDTO
    {
        $this->city = $city;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): RegisterUserDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): RegisterUserDTO
    {
        $this->password = $password;
        return $this;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function setPasswordConfirmation(string $passwordConfirmation): RegisterUserDTO
    {
        $this->passwordConfirmation = $passwordConfirmation;
        return $this;
    }
}