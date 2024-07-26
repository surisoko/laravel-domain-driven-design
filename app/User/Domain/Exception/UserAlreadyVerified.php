<?php

namespace App\User\Domain\Exception;

class UserAlreadyVerified extends \Exception
{
    public static function execute(): UserAlreadyVerified
    {
        return new self("User already verified");
    }
}
