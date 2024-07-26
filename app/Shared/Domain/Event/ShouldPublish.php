<?php

namespace App\Shared\Domain\Event;

interface ShouldPublish
{
    public function toPublisher(): array;
    public function occurredOn(): int;
}
