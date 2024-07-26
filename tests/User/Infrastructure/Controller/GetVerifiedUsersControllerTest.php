<?php

namespace Tests\User\Infrastructure\Controller;

use App\User\Infrastructure\Model\User;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('get a list of verified users', function () {
    $eloquentUser = User::factory()->create();
    $user = ParseUserToDomain::fromEloquent($eloquentUser);

    $response = $this->get(route('list.users'))
        ->assertOk()
        ->decodeResponseJson();

    $users = $response->json();

    expect($users)
        ->toHaveCount(1)
        ->and($users[0])->toEqual([
            'id' => $user->id()->getValue(),
            'name' => $user->name()->getValue(),
            'email' => $user->email()->getValue(),
            'role' => $user->role()->value,
            'verified_at' => $user->emailVerifiedAt()->toISOString(),
            'created_at' => $user->createdAt()->toISOString(),
        ]);
});

test('return an empty list if there are no users', function () {
    $response = $this->get(route('list.users'))
        ->assertOk()
        ->decodeResponseJson();

    expect($response->json())->toBeEmpty();
});
