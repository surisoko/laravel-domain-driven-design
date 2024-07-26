<?php

namespace App\User\Infrastructure\Service;

use App\User\Domain\Service\EmailDeliveryService;
use App\User\Domain\ValueObject\UserEmail;

class MailtrapEmailDeliveryService implements EmailDeliveryService
{
    public function sendTo(UserEmail $email, $params = []): void
    {
        // send email with external service
    }
}
