<?php

namespace Tests\User\Infrastructure\Parser;

use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Faker\fake;
use Tests\TestCase;

uses(RefreshDatabase::class, TestCase::class);

test('parse infrastructure use to domain', function () {
    $eloquentUser = EloquentUser::factory()->create([
        'name' => fake()->firstName,
    ]);

    $user = ParseUserToDomain::fromEloquent($eloquentUser);

    expect($user->id()->getValue())->toEqual($eloquentUser->id)
        ->and($user->name()->getValue())->toEqual($eloquentUser->name)
        ->and($user->email()->getValue())->toEqual($eloquentUser->email)
        ->and($user->password()->getValue())->toEqual($eloquentUser->password)
        ->and(
            $user->emailVerifiedAt()->toIso8601String()
        )->toEqual(
            Carbon::parse($eloquentUser->email_verified_at)->toIso8601String()
        )
        ->and($user->rememberToken())->toEqual($eloquentUser->remember_token)
        ->and($user->createdAt()->toIso8601String())->toEqual($eloquentUser->created_at->toIso8601String());
});
