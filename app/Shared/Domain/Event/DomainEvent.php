<?php

namespace App\Shared\Domain\Event;

interface DomainEvent
{
    public function toSerialized(): array;
    public function occurredOn(): int;
}
