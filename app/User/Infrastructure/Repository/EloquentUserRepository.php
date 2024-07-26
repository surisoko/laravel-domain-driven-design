<?php

namespace App\User\Infrastructure\Repository;

use App\Shared\Domain\Exception\User\UserNotFound;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserId;
use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserListToDomain;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        EloquentUser::query()->updateOrCreate([
            'id' => $user->id()->getValue(),
        ],[
            'email' => $user->email()->getValue(),
            'name' => $user->name()->getValue(),
            'password' => $user->password()->getValue(),
            'role' => $user->role()->value,
            'email_verified_at' => $user->emailVerifiedAt(),
            'remember_token' => $user->rememberToken(),
            'created_at' => $user->createdAt(),
        ]);
    }

    /**
     * @throws UserNotFound
     */
    public function findByEmailOrFail(UserEmail $userEmail): User
    {
        try {
            $eloquentUser = EloquentUser::query()
                ->where('email', '=', $userEmail->getValue())
                ->firstOrFail();

            return ParseUserToDomain::fromEloquent($eloquentUser);
        } catch (ModelNotFoundException) {
            throw UserNotFound::execute();
        }
    }

    /**
     * @throws UserNotFound
     */
    public function findByIdOrFail(UserId $userId): User
    {
        try {
            $eloquentUser = EloquentUser::query()
                ->where('id', '=', $userId->getValue())
                ->firstOrFail();

            return ParseUserToDomain::fromEloquent($eloquentUser);
        } catch (ModelNotFoundException) {
            throw UserNotFound::execute();
        }
    }

    public function getVerified(): array
    {
        $eloquentUsers = EloquentUser::query()
            ->whereNotNull('email_verified_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return ParseUserListToDomain::fromEloquent($eloquentUsers);
    }
}
