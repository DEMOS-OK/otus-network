<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Controllers\API;

use App\SocialNetwork\Application\Auth\Actions\LoginUser;
use App\SocialNetwork\Application\Auth\Actions\RegisterUser;
use App\SocialNetwork\Application\Auth\Exceptions\BadCredentialsException;
use App\SocialNetwork\Application\Auth\Exceptions\InvalidPasswordConfirmationException;
use App\SocialNetwork\UI\Http\Controllers\Controller;
use App\SocialNetwork\UI\Http\Requests\LoginRequest;
use App\SocialNetwork\UI\Http\Requests\RegisterRequest;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginUser $loginUser): JsonResponse
    {
        try {
            $user = $loginUser($request->data());
        } catch (BadCredentialsException) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Bad credentials'
            ], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        $token = JWT::encode([
            'iss' => Config::get('app.name'),
            'sub' => $user->getId(),
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ], Config::get('auth.jwt_secret'), 'HS256');

        return new JsonResponse([
            'success' => true,
            'data' => [
                'jwt' => $token,
                'user' => $user->toArray(),
            ]
        ]);
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