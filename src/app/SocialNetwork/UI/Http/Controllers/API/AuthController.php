<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Controllers\API;

use App\SocialNetwork\Application\Auth\Exceptions\InvalidPasswordConfirmationException;
use App\SocialNetwork\Application\Auth\RegisterUser;
use App\SocialNetwork\UI\Http\Controllers\Controller;
use App\SocialNetwork\UI\Http\Requests\LoginRequest;
use App\SocialNetwork\UI\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        dd('test');
    }

    public function register(RegisterRequest $request, RegisterUser $registerUser): JsonResponse
    {
        try {
            $user = $registerUser($request->data());

            return new JsonResponse([
                'success' => true,
                'data' => [
                    'user' => $user->toArray(),
                ],
            ]);
        } catch (InvalidPasswordConfirmationException) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Invalid password confirmation',
            ], SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}