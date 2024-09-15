<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Requests;

use App\SocialNetwork\Application\Auth\DTO\LoginUserDTO;

final class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|min:8|max:32',
        ];
    }

    public function data(): LoginUserDTO
    {
        return (new LoginUserDTO(
            $this->input('email'),
            $this->input('password'),
        ));
    }
}