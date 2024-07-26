<?php

namespace App\User\Application\UseCase;

use App\Shared\Domain\Event\EventBus;
use App\Shared\Domain\Exception\User\UserNotFound;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserAlreadyExists;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserPassword;
use App\User\Domain\ValueObject\UserRole;

class CreateUser
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EventBus $eventBus,
    ) {
    }

    public function execute(
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword,
        UserRole $userRole,
    ): void {
        try {
            $user = $this->userRepository->findByEmailOrFail($userEmail);
            throw UserAlreadyExists::execute($user);
        } catch (UserNotFound) {
        }

        $user = User::create(
            name: $userName,
            email: $userEmail,
            password: $userPassword,
            role: $userRole,
        );

        $this->userRepository->save($user);
        $this->eventBus->publish($user->events());
    }
}
