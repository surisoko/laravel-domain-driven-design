<?php

namespace App\User\Domain\Service;

use App\User\Domain\ValueObject\UserEmail;

interface EmailDeliveryService
{
    public function sendTo(UserEmail $email, $params = []): void;
}
