<?php

namespace App\User\Domain\Service;

use App\User\Domain\ValueObject\UserEmail;

class FakeEmailDeliveryService implements EmailDeliveryService
{
    public bool $emailWasSent = false;
    public UserEmail $email;
    public function sendTo(UserEmail $email, $params = []): void
    {
        $this->email = $email;
        $this->emailWasSent = true;
    }
}
