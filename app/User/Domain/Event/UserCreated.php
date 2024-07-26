<?php

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\ShouldPublish;
use App\User\Domain\Entity\User;
use App\User\Domain\ValueObject\UserId;

class UserCreated implements DomainEvent, ShouldPublish
{
    private int $occurredOn;

    public function __construct(private readonly User $user)
    {
        $this->occurredOn = time();
    }

    public function userId(): UserId
    {
        return $this->user->id();
    }

    public function toSerialized(): array
    {
        return [
            'user_id' => $this->user->id()->getValue(),
        ];
    }

    public function toPublisher(): array
    {
        return [
            'user_id' => $this->user->id()->getValue(),
            'user_name' => $this->user->name()->getValue(),
            'user_email' => $this->user->email()->getValue(),
            'user_verified_at' => $this->user->emailVerifiedAt()?->toString(),
        ];
    }

    public function occurredOn(): int
    {
        return $this->occurredOn;
    }
}
