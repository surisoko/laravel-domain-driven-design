<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\UseCase\GetVerifiedUsers;
use Illuminate\Http\JsonResponse;

class GetVerifiedUsersController
{
    public function __construct(private readonly GetVerifiedUsers $getVerifiedUsers)
    {
    }

    public function __invoke(): JsonResponse
    {
        $users = $this->getVerifiedUsers->execute();

        return response()->json($users);
    }
}
