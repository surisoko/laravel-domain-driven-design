<?php

namespace App\User\Infrastructure\Listener;

use App\User\Domain\Event\UserCreated;
use App\User\Domain\Listener\SendVerificationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationEmailSubscriber implements ShouldQueue
{
    public function __construct(private readonly SendVerificationEmail $sendVerificationEmail)
    {
    }

    public function handle(UserCreated $userCreatedEvent): void
    {
        $this->sendVerificationEmail->execute($userCreatedEvent->userId());
    }
}
