<?php

declare(strict_types=1);

namespace App\SocialNetwork\Infrastructure\Repositories\Eloquent;

use App\Models\User as UserModel;
use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Entities\UserInfo;
use App\SocialNetwork\Domain\User\Enums\GenderEnum;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use App\SocialNetwork\Infrastructure\Repositories\Eloquent\Models\UserInfo as UserInfoModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        if ($user->getId() !== null) {
            return $this->update($user);
        }

        $userModel = $this->mapUserEntityToUserModel($user);
        $userModel->save();

        $this->saveRelations($userModel, $user);

        return $this->mapUserModelToUserEntity($userModel);
    }

    private function update(User $user): User
    {
        $userModel = UserModel::query()->find($user->getId());
        $userModel->update($user->toArray());

        $this->updateRelations($userModel, $user);

        return $this->mapUserModelToUserEntity($userModel);
    }

    private function updateRelations(UserModel $userModel, User $user): void
    {
        $userInfoModel = $this->mapUserInfoEntityToUserInfoModel($user->getInfo());

        // Update user info
        $userModel->info()->update($userInfoModel->toArray());

        // Update friends
        $friends = Collection::make($user->getFriends());
        $userModel->friends()->sync($friends->map(fn(User $friend) => $friend->getId()));
    }

    private function mapUserInfoEntityToUserInfoModel(UserInfo $userInfoEntity): UserInfoModel
    {
        $userInfoModel = new UserInfoModel();
        if ($userInfoEntity->getId() !== null) {
            $userInfoModel->id = $userInfoEntity->getId();
        }
        $userInfoModel->firstname = $userInfoEntity->getName();
        $userInfoModel->lastname = $userInfoEntity->getLastname();
        $userInfoModel->date_of_birth = $userInfoEntity->getDateOfBirth();
        $userInfoModel->gender = $userInfoEntity->getGender()->value;
        $userInfoModel->about = $userInfoEntity->getAbout();
        $userInfoModel->city = $userInfoEntity->getCity();

        return $userInfoModel;
    }

    private function mapUserModelToUserEntity(UserModel $model): User
    {
        $user = new User();
        $user->setId($model->id);
        $user->setName($model->name);
        $user->setEmail($model->email);
        $user->setPassword($model->password);
        $user->setEmailVerifiedAt($model->email_verified_at?->toDateTimeString());
        $user->setRememberToken($model->remember_token);
        if ($model->relationLoaded('info')) {
            $user->setInfo($this->mapUserInfoModelToUserInfoEntity($model->info));
        }
        if ($model->relationLoaded('friends')) {
            $friends = [];
            foreach ($model->friends as $friend) {
                $friends[] = $this->mapUserModelToUserEntity($friend);
            }
            $user->setFriends($friends,);
        }

        return $user;
    }

    private function mapUserInfoModelToUserInfoEntity(UserInfoModel $model): UserInfo
    {
        $userInfo = new UserInfo();
        $userInfo->setId($model->id);
        $userInfo->setName($model->firstname);
        $userInfo->setLastname($model->lastname);
        $userInfo->setDateOfBirth($model->date_of_birth);
        $userInfo->setCity($model->city);
        $userInfo->setGender(GenderEnum::from((int)$model->gender));
        $userInfo->setAbout($model->about);

        return $userInfo;
    }

    private function mapUserEntityToUserModel(User $user): UserModel
    {
        $userModel = new UserModel();
        if ($user->getId() !== null) {
            $userModel->id = $user->getId();
        }

        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();

        return $userModel;
    }

    private function saveRelations(UserModel $userModel, User $user): void
    {
        $userInfoModel = $this->mapUserInfoEntityToUserInfoModel($user->getInfo());

        // Save user info
        $userModel->info()->save($userInfoModel);

        // Save friends
        $friends = Collection::make($user->getFriends());
        $userModel->friends()->attach($friends->map(fn(User $friend) => $friend->getId()));
    }

    public function findById(int $id): ?User
    {
        $userModel = UserModel::query()->with(['info', 'friends'])->find($id);

        if ($userModel === null) {
            return null;
        }

        return $this->mapUserModelToUserEntity($userModel);
    }

    public function findByEmail(string $email): ?User
    {
        $userModel = UserModel::query()->with(['info'])->where('email', $email)->first();

        if ($userModel === null) {
            return null;
        }

        return $this->mapUserModelToUserEntity($userModel);
    }

    public function findByInitials(string $firstname, string $lastname): Collection
    {
        $userModels = UserModel::query()->with(['info'])
            ->whereHas(
                'info',
                function (Builder|UserInfoModel $query) use ($firstname, $lastname) {
                    $query->where('firstname', 'like', $firstname . '%')
                        ->where('lastname', 'like', $lastname . '%');
                }
            )->get();

        return $userModels->map(fn(UserModel $userModel) => $this->mapUserModelToUserEntity($userModel));
    }

    public function getFriendsForUser(int $userId): Collection
    {
        $userModel = UserModel::query()->with(['friends'])->find($userId);

        if ($userModel === null) {
            return new Collection();
        }

        return $userModel->friends->map(fn(UserModel $userModel) => $this->mapUserModelToUserEntity($userModel));
    }
}