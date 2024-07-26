<?php

namespace App\User\Domain\Exception;

class InvalidUserRole extends \Exception
{
    public static function notAllowed(): self
    {
        return new self('Invalid role');
    }
}
