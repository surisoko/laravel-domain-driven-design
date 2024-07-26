<?php

namespace App\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserName;

class UserName
{
    private function __construct(private readonly string $name)
    {
        if (strlen($name) < 2) {
            throw InvalidUserName::nameIsToShort();
        }

        if (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$$/', $name)) {
            throw InvalidUserName::onlyCharacters();
        }
    }

    /**
     * @throws InvalidUserName
     */
    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
