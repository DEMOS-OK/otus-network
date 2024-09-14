<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Requests;

use App\SocialNetwork\Application\Auth\DTO\RegisterUserDTO;
use App\SocialNetwork\Domain\User\Enums\GenderEnum;

final class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:128',
            'lastname' => 'required|string|max:128',
            'date_of_birth' => 'required|date',
            'gender' => 'required|integer:1,2',
            'about' => 'required|min:3|max:1000',
            'city' => 'required|string',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:32',
            'password_confirmation' => 'required|min:8|max:32',
        ];
    }

    public function data(): RegisterUserDTO
    {
        return new RegisterUserDTO(
            $this->input('firstname'),
            $this->input('lastname'),
            $this->input('date_of_birth'),
            $this->integer('gender') === 1 ? GenderEnum::Male : GenderEnum::Female,
            $this->input('about'),
            $this->input('city'),
            $this->input('email'),
            $this->input('password'),
            $this->input('password_confirmation'),
        );
    }
}