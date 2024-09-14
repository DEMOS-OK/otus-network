<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Requests;

final class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:32',
        ];
    }
}