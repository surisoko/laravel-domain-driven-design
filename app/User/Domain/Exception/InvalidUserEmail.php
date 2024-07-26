<?php

namespace App\User\Domain\Exception;

class InvalidUserEmail extends \Exception
{
    public static function execute(): self
    {
        return new self('Invalid Email Address');
    }
}
