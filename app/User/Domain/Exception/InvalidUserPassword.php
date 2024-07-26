<?php

namespace App\User\Domain\Exception;

class InvalidUserPassword extends \Exception
{
    public static function toShort(): self
    {
        return new self('Password to short, min 5 characters');
    }
}
