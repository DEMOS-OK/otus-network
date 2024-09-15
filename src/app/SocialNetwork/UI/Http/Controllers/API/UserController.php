<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Controllers\API;

use App\SocialNetwork\Application\Auth\Exceptions\UserNotFoundException;
use App\SocialNetwork\Application\User\Actions\FindUser;
use App\SocialNetwork\UI\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    public function find(int $id, FindUser $findUser): JsonResponse
    {
        try {
            $user = $findUser($id);
        } catch (UserNotFoundException) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not found',
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'data' => [
                'user' => $user->toArray(),
            ],
        ]);
    }
}