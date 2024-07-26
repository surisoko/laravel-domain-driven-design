<?php

namespace App\User\Infrastructure\Parser;

use App\User\Infrastructure\Model\User;
use Illuminate\Database\Eloquent\Collection;

class ParseUserListToDomain
{
    public static function fromEloquent(Collection $eloquentUsers): array
    {
        return $eloquentUsers->map(function (User $eloquentUser) {
            return ParseUserToDomain::fromEloquent($eloquentUser);
        })->toArray();
    }
}
