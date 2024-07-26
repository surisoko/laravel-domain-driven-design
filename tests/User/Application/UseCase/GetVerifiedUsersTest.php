<?php

namespace Tests\User\Infrastructure\Controller;

use App\User\Application\UseCase\GetVerifiedUsers;
use App\User\Infrastructure\Model\User;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use App\User\Infrastructure\Repository\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('get a list of verified users', function () {
    $eloquentUser = User::factory([
        'email_verified_at' => now(),
    ])->create();
    $user = ParseUserToDomain::fromEloquent($eloquentUser);
    $getVerifiedUsers = new GetVerifiedUsers(new EloquentUserRepository());

    $users = $getVerifiedUsers->execute();

    expect($users)->toHaveCount(1)
        ->and($users[0])->toEqual([
            'id' => $user->id()->getValue(),
            'name' => $user->name()->getValue(),
            'email' => $user->email()->getValue(),
            'role' => $user->role()->value,
            'verified_at' => $user->emailVerifiedAt()->toISOString(),
            'created_at' => $user->createdAt()->toISOString(),
        ]);
});
