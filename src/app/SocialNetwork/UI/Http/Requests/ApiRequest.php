<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'errors' => $errors
                ],
                Response::HTTP_BAD_REQUEST
            )
        );
    }
}