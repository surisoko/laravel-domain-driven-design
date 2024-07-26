<?php

namespace App\User\Application\UseCase;

use App\Shared\Domain\Exception\User\UserNotFound;
use App\User\Domain\Exception\UserAlreadyVerified;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\UserId;

class VerifyUser
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @throws UserNotFound
     * @throws UserAlreadyVerified
     */
    public function execute(UserId $userId): void
    {
        $user = $this->userRepository->findByIdOrFail($userId);
        if ($user->verified()) {
            throw UserAlreadyVerified::execute();
        }

        $user->verify();
        $this->userRepository->save($user);
    }
}
