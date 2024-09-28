<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Controllers\API;

use App\SocialNetwork\Application\Auth\Exceptions\UserNotFoundException;
use App\SocialNetwork\Application\User\Actions\FindUser;
use App\SocialNetwork\Application\User\Actions\FindUsersByInitials;
use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\UI\Http\Controllers\Controller;
use App\SocialNetwork\UI\Http\Requests\UserSearchRequest;
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

    public function search(UserSearchRequest $request, FindUsersByInitials $findUsersByInitials): JsonResponse
    {
        $firstname = $request->getFirstname();
        $lastname = $request->getLastname();

        $users = $findUsersByInitials($firstname, $lastname);

        return new JsonResponse([
            'success' => true,
            'data' => [
                'users' => $users->map(fn (User $user) => $user->toArray()),
            ]
        ]);
    }
}