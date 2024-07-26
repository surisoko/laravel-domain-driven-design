<?php

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\EventBus;

class FakeEventBus implements EventBus
{
    public bool $wasDispatched = false;
    private array $events;

    public function publish(array $events): void
    {
        $this->wasDispatched = true;

        $this->events = $events;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
