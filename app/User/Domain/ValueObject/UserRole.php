<?php

namespace App\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserRole;

enum UserRole: string
{
    case administrator = 'administrator';
    case editor = 'editor';

    /**
     * @throws InvalidUserRole
     */
    public static function fromString(string $role): self
    {
        if (!in_array($role, [self::administrator->value, self::editor->value])) {
            throw InvalidUserRole::notAllowed();
        }

        return self::from($role);
    }
}
