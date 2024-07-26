<?php

namespace App\User\Infrastructure\Provider;

use App\User\Domain\Repository\UserRepository;
use App\User\Domain\Service\EmailDeliveryService;
use App\User\Infrastructure\Repository\EloquentUserRepository;
use App\User\Infrastructure\Service\MailtrapEmailDeliveryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(EmailDeliveryService::class, MailtrapEmailDeliveryService::class);
    }
}
