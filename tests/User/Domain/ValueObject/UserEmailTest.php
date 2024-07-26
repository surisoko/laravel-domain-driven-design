<?php

namespace Tests\User\Domain\ValueObject;

use App\User\Domain\Exception\InvalidUserEmail;
use App\User\Domain\ValueObject\UserEmail;
use Tests\TestCase;

uses(TestCase::class);

test('create a new user email', function () {
    $userEmail = UserEmail::fromString($email = fake()->email);

    expect($email)->toEqual($userEmail->getValue());
});

test('throw invalid user email exception if user email is not valid', function () {
    UserEmail::fromString(fake()->word);
})->throws(InvalidUserEmail::class);

test('validate if two emails are equals', function () {
    $email = fake()->email;
    $emailOne = UserEmail::fromString($email);
    $emailTwo = UserEmail::fromString($email);

    expect($emailOne->equals($emailTwo))->toBeTruthy();
});
