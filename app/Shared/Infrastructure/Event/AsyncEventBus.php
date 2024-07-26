<?php

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\EventBus;

class AsyncEventBus implements EventBus
{
    public function publish(array $events): void
    {
        foreach($events as $event) {
            event($event);
        }
    }
}
