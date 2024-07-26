<?php

namespace App\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserEmail;

class UserEmail
{
    private function __construct(private readonly string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidUserEmail::execute();
        }
    }

    /**
     * @throws InvalidUserEmail
     */
    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function equals(UserEmail $email): bool
    {
        return $this->email === $email->getValue();
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
