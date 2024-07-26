<?php

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\DomainEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEvent implements ShouldQueue
{
    public function handle(DomainEvent $event)
    {
        // log events to datadog, kibana or other
    }
}
