<?php

namespace App\Shared\Infrastructure\Provider;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\ShouldPublish;
use App\Shared\Infrastructure\Event\LogEvent;
use App\Shared\Infrastructure\Event\PublishEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Event::listen(DomainEvent::class, LogEvent::class);
        Event::listen(ShouldPublish::class, PublishEvent::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
