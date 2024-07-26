<?php

namespace App\User\Domain\Repository;

use App\Shared\Domain\Exception\User\UserNotFound;
use App\User\Domain\Entity\User;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserId;

interface UserRepository
{
    public function save(User $user): void;

    /**
     * @throws UserNotFound
     */
    public function findByEmailOrFail(UserEmail $userEmail): User;

    /**
     * @throws UserNotFound
     */
    public function findByIdOrFail(UserId $userId): User;

    public function getVerified(): array;
}
