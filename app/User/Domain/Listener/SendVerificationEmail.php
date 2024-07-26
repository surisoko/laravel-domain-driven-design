<?php

namespace App\User\Domain\Listener;

use App\User\Domain\Repository\UserRepository;
use App\User\Domain\Service\EmailDeliveryService;
use App\User\Domain\ValueObject\UserId;

class SendVerificationEmail
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EmailDeliveryService $emailDeliveryService
    ) {
    }

    public function execute(UserId $userId): void
    {
        $user = $this->userRepository->findByIdOrFail($userId);

        $this->emailDeliveryService->sendTo($user->email(), [
            'id' => $user->id()
        ]);
    }
}
