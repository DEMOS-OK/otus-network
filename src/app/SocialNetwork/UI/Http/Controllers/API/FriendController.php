<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Controllers\API;

use App\SocialNetwork\Application\Auth\Exceptions\UserNotFoundException;
use App\SocialNetwork\Application\User\Actions\AddFriend;
use App\SocialNetwork\Application\User\Actions\DeleteFriend;
use App\SocialNetwork\Application\User\Actions\GetFriends;
use App\SocialNetwork\UI\Http\Controllers\Controller;
use App\SocialNetwork\UI\Http\Requests\ApiRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class FriendController extends Controller
{
    public function __construct(
        private readonly AddFriend $addFriend,
        private readonly DeleteFriend $deleteFriend,
        private readonly GetFriends $getFriends,
    ) {
    }

    public function addFriend(ApiRequest $request, int $friendId): JsonResponse
    {
        try {
            ($this->addFriend)($request->userId(), $friendId);
        } catch (UserNotFoundException) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not found',
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Friend added successfully',
        ]);
    }

    public function deleteFriend(ApiRequest $request, int $friendId): JsonResponse
    {
        try {
            ($this->deleteFriend)($request->userId(), $friendId);
        } catch (UserNotFoundException) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not found'
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Friend removed successfully',
        ]);
    }

    public function getFriends(ApiRequest $request): JsonResponse
    {
        $friends = ($this->getFriends)($request->userId());

        return new JsonResponse([
            'success' => true,
            'data' => $friends->toArray(),
        ]);
    }
}