<?php

declare(strict_types=1);

namespace App\SocialNetwork\Infrastructure\Repositories\Eloquent;

use App\SocialNetwork\Domain\User\Entities\User;
use App\SocialNetwork\Domain\User\Entities\UserInfo;
use App\SocialNetwork\Domain\User\Enums\GenderEnum;
use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use App\SocialNetwork\Infrastructure\Repositories\Eloquent\Models\User as UserModel;
use App\SocialNetwork\Infrastructure\Repositories\Eloquent\Models\UserInfo as UserInfoModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $userModel = $this->mapUserEntityToUserModel($user);
        $userModel->save();

        $this->saveRelations($userModel, $user);

        return $this->mapUserModelToUserEntity($userModel);
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

        $userModel->info()->save($userInfoModel);
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
        if ($model->info !== null) {
            $user->setInfo($this->mapUserInfoModelToUserInfoEntity($model->info));
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

    public function findById(int $id): ?User
    {
        $userModel = UserModel::query()->with(['info'])->find($id);

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
}