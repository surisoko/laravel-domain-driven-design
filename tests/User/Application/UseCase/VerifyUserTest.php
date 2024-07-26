<?php

namespace Tests\User\Application\UseCase;

use App\Shared\Domain\Exception\User\UserNotFound;
use App\User\Application\UseCase\VerifyUser;
use App\User\Domain\Exception\UserAlreadyVerified;
use App\User\Domain\ValueObject\UserId;
use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use App\User\Infrastructure\Repository\EloquentUserRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('verify user account', function () {
    Carbon::setTestNow($verificationDate = Carbon::now());
    $eloquentUser = EloquentUser::factory()->create([
        'email_verified_at' => null,
    ]);
    $user = ParseUserToDomain::fromEloquent($eloquentUser);

    $verifyUser = new VerifyUser(
        new EloquentUserRepository()
    );

    $verifyUser->execute($user->id());

    $userVerified = ParseUserToDomain::fromEloquent($eloquentUser->fresh());
    expect($userVerified->emailVerifiedAt()->timestamp)->toEqual($verificationDate->timestamp);
});

test("throw unauthorized exception if user is already verified", function () {
    $eloquentUser = EloquentUser::factory()->create([
        'email_verified_at' => Carbon::now(),
    ]);
    $verifyUser = new VerifyUser(
        new EloquentUserRepository()
    );

    $verifyUser->execute(UserId::fromString($eloquentUser->id));
})->expectException(UserAlreadyVerified::class);

test("throw not found exception if user doesn't exist", function () {
    $verifyUser = new VerifyUser(
        new EloquentUserRepository()
    );

    $verifyUser->execute(UserId::fromString(fake()->uuid));
})->expectException(UserNotFound::class);
