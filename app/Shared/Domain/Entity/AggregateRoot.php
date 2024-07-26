<?php

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    public function record(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function events(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }
}
