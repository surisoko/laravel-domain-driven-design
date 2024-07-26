<?php

namespace App\Shared\Infrastructure\Provider;

use App\Shared\Domain\Event\EventBus;
use App\Shared\Infrastructure\Event\AsyncEventBus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EventBus::class, AsyncEventBus::class);
    }
}
