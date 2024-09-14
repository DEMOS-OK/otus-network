<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Entities;

use App\SocialNetwork\Domain\User\Enums\GenderEnum;

final class UserInfo extends Entity
{
    private int $id;

    private string $name;

    private string $lastname;

    private string $dateOfBirth;

    private GenderEnum $gender;

    private string $about;

    private string $city;

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

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->name,
            'lastname' => $this->lastname,
            'date_of_birth' => $this->dateOfBirth,
            'gender' => $this->gender,
            'about' => $this->about,
            'city' => $this->city,
        ];
    }
}