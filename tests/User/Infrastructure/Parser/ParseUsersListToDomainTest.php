<?php

namespace Tests\User\Infrastructure\Parser;

use App\User\Domain\Entity\User;
use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserListToDomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('parse users eloquent collection to domain', function () {
    $eloquentUsers = EloquentUser::factory(2)->create();
    $users = ParseUserListToDomain::fromEloquent($eloquentUsers);

    expect($users)->toHaveCount(2)
        ->and($users)->toContainOnlyInstancesOf(User::class);
});
