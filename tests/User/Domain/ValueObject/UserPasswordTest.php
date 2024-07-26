<?php

namespace Tests\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserPassword;
use App\User\Domain\ValueObject\UserPassword;

test('create a new user password', function () {
    $userPassword = UserPassword::fromString($password = fake()->password(5));

    expect($userPassword->getValue())->toEqual($password);
});

test('throw invalid user password exception if user password is to short', function () {
    UserPassword::fromString(fake()->password(1, 4));
})->expectExceptionMessage(InvalidUserPassword::toShort()->getMessage());
