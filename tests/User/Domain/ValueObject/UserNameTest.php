<?php

namespace Tests\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserName;
use App\User\Domain\ValueObject\UserName;

test('create a new user name', function () {
    $userName = UserName::fromString($name = fake()->firstName);

    expect($name)->toEqual($userName->getValue());
});

test('throw invalid user name exception if user name has numbers', function () {
    UserName::fromString((string) fake()->numberBetween());
})->expectExceptionMessage(InvalidUserName::onlyCharacters()->getMessage());

test('throw invalid user name exception if user name is short', function () {
    UserName::fromString(fake()->randomLetter);
})->expectExceptionMessage(InvalidUserName::nameIsToShort()->getMessage());
