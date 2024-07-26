<?php

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\Exception\InvalidUuid;
use Ramsey\Uuid\Uuid;

class UserId
{
    private function __construct(private readonly string $uuid)
    {
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $id): self
    {
        if (!Uuid::isValid($id)) {
            throw InvalidUuid::execute($id);
        }
        return new self($id);
    }

    public function getValue(): string
    {
        return $this->uuid;
    }
}
