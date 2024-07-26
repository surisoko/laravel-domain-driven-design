<?php

namespace App\User\Infrastructure\Provider;

use App\User\Domain\Event\UserCreated;
use App\User\Infrastructure\Listener\SendVerificationEmailSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreated::class => [
            SendVerificationEmailSubscriber::class,
        ]
    ];
}
