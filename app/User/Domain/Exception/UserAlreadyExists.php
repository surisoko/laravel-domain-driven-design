<?php

namespace App\User\Domain\Exception;

use App\User\Domain\Entity\User;

class UserAlreadyExists extends \Exception
{
    public static function execute(User $user): self
    {
        return new self("User already exists {$user->email()->getValue()}");
    }
}
