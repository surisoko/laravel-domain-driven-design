<?php

namespace Tests\User\Infrastructure\Controller;

use App\User\Infrastructure\Model\User as EloquentUser;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('verify user account', function () {
    Carbon::setTestNow($verificationDate = Carbon::now());
    $user = EloquentUser::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->put(route('verify.user', [
        'id' => $user->id,
    ]));

    expect($user->fresh()->email_verified_at->timestamp)->toEqual($verificationDate->timestamp);
});

test("return unauthorized if user is already verified", function () {
    $user = EloquentUser::factory()->create([
        'email_verified_at' => Carbon::now(),
    ]);

    $this->put(route('verify.user', [
        'id' => $user->id,
    ]))->assertUnauthorized();
});

test("return not found if user doesn't exist", function () {
    $this->put(route('verify.user', [
        'id' => fake()->uuid(),
    ]))->assertNotFound();
});

test('return unprocessable entity if user id is not valid', function () {
    $this->put(route('verify.user', [
        'id' => fake()->text(),
    ]))->assertUnprocessable();
});
