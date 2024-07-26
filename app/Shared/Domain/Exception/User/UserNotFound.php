<?php

namespace App\Shared\Domain\Exception\User;

class UserNotFound extends \Exception
{
    public static function execute(): self
    {
        return new self('User not found');
    }
}
