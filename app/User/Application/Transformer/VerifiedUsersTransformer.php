<?php

namespace App\User\Application\Transformer;

use App\User\Domain\Entity\User;

class VerifiedUsersTransformer
{
    public static function toArray(array $users): array
    {
        $verifiedUsers = [];

        /** @var User $user */
        foreach ($users as $user) {
            $verifiedUsers[] = [
                'id' => $user->id()->getValue(),
                'name' => $user->name()->getValue(),
                'email' => $user->email()->getValue(),
                'role' => $user->role()->value,
                'verified_at' => $user->emailVerifiedAt()->toISOString(),
                'created_at' => $user->createdAt()->toISOString(),
            ];
        }

        return $verifiedUsers;
    }
}
