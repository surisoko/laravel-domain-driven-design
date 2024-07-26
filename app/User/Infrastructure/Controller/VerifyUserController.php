<?php

namespace App\User\Infrastructure\Controller;

use App\Shared\Domain\Exception\InvalidUuid;
use App\Shared\Domain\Exception\User\UserNotFound;
use App\User\Application\UseCase\VerifyUser;
use App\User\Domain\Exception\UserAlreadyVerified;
use App\User\Domain\ValueObject\UserId;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VerifyUserController
{
    public function __construct(private readonly VerifyUser $verifyUser)
    {
    }

    public function __invoke(string $userId): JsonResponse
    {
        try {
            $this->verifyUser->execute(
                UserId::fromString($userId)
            );

            return response()->json([], Response::HTTP_OK);
        } catch (UserNotFound) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        } catch (InvalidUuid) {
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (UserAlreadyVerified) {
            return response()->json([], Response::HTTP_UNAUTHORIZED);
        }
    }
}
