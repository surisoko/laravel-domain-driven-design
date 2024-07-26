<?php

namespace App\User\Application\UseCase;

use App\User\Application\Transformer\VerifiedUsersTransformer;
use App\User\Domain\Repository\UserRepository;

class GetVerifiedUsers
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function execute(): array
    {
        $users = $this->userRepository->getVerified();

        return VerifiedUsersTransformer::toArray($users);
    }
}
