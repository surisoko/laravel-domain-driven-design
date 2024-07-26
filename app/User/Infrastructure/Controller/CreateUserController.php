<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\UseCase\CreateUser;
use App\User\Domain\Exception\InvalidUserEmail;
use App\User\Domain\Exception\InvalidUserName;
use App\User\Domain\Exception\InvalidUserPassword;
use App\User\Domain\Exception\InvalidUserRole;
use App\User\Domain\Exception\UserAlreadyExists;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserPassword;
use App\User\Domain\ValueObject\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateUserController
{
    public function __construct(private readonly CreateUser $createUser)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        try {
            $this->createUser->execute(
                userName: UserName::fromString($request->get('name')),
                userEmail: UserEmail::fromString($request->get('email')),
                userPassword: UserPassword::fromString($request->get('password')),
                userRole: UserRole::fromString($request->get('role'))
            );

            return response()->json([], Response::HTTP_CREATED);
        } catch (InvalidUserName | InvalidUserEmail | InvalidUserPassword | InvalidUserRole $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (UserAlreadyExists $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_CONFLICT);
        } catch(\Exception $exception) {
            return response()->json([ 'message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
