<?php

namespace App\User\Domain\Exception;

class InvalidUserName extends \Exception
{
    public static function nameIsToShort(): self
    {
        return new self('Name is to short, max value 30 characters');
    }

    public static function onlyCharacters(): self
    {
        return new self('Invalid name, only characters are allowed');
    }
}
