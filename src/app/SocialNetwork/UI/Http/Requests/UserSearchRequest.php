<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Requests;

final class UserSearchRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
        ];
    }

    public function getFirstname(): string
    {
        return $this->input('firstname');
    }

    public function getLastname(): string
    {
        return $this->input('lastname');
    }
}