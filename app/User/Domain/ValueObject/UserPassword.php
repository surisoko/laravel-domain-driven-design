<?php

namespace App\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserPassword;

class UserPassword
{
    private function __construct(private readonly string $password)
    {
        if(strlen($password) < 5) {
            throw InvalidUserPassword::toShort();
        }
    }

    /**
     * @throws InvalidUserPassword
     */
    public static function fromString(string $password): self
    {
        return new self($password);
    }

    public function getValue(): string
    {
        return $this->password;
    }
}
