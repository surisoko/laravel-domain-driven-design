<?php

namespace App\User\Infrastructure\Parser;

use App\User\Domain\Entity\User;
use App\User\Infrastructure\Model\User as EloquentUser;
use Carbon\Carbon;

class ParseUserToDomain
{
    public static function fromEloquent(EloquentUser $eloquentUser): User
    {
        $user = (object) [
            'id' => $eloquentUser->id,
            'name' => $eloquentUser->name,
            'email' => $eloquentUser->email,
            'password' => $eloquentUser->password,
            'role' => $eloquentUser->role,
            'emailVerifiedAt' => $eloquentUser->email_verified_at
                ? Carbon::parse($eloquentUser->email_verified_at)
                : null,
            'rememberToken' => $eloquentUser->remember_token,
            'createdAt' => $eloquentUser->created_at,
        ];

        return User::fromPrimitives($user);
    }
}
