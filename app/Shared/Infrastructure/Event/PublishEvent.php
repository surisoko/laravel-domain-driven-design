<?php

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\ShouldPublish;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PublishEvent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ShouldPublish $event): void
    {
        // send your event to a specific queue configured in queue.php
    }
}
