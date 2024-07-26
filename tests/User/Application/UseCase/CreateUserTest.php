<?php

namespace Tests\User\Application;

use App\Shared\Infrastructure\Event\FakeEventBus;
use App\User\Application\UseCase\CreateUser;
use App\User\Domain\Event\UserCreated;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserPassword;
use App\User\Domain\ValueObject\UserRole;
use App\User\Infrastructure\Model\User;
use App\User\Infrastructure\Repository\EloquentUserRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('create a new user', function () {
    Carbon::setTestNow($now = Carbon::now());
    $createUser = new CreateUser(
        new EloquentUserRepository(),
        new FakeEventBus()
    );

    $createUser->execute(
        userName: $userName = UserName::fromString(fake()->firstName),
        userEmail: $userEmail = UserEmail::fromString(fake()->email),
        userPassword: $userPassword = UserPassword::fromString(fake()->password(5)),
        userRole: $userRole = UserRole::editor
    );

    $this->assertDatabaseHas('users', [
        'email' => $userEmail->getValue(),
        'name' => $userName->getValue(),
        'email_verified_at' => null,
        'role' => $userRole->value,
        'remember_token' => null,
        'created_at' => $now
    ]);

    $user = User::query()->where('email', '=', $userEmail->getValue())->first();
    expect(Hash::check($userPassword->getValue(), $user->password))->toBeTruthy();
});

test('dispatch user created event', function () {
    $fakeEventBus = new FakeEventBus();
    $createUser = new CreateUser(
        new EloquentUserRepository(),
        $fakeEventBus
    );

    $createUser->execute(
        userName: UserName::fromString(fake()->firstName),
        userEmail: UserEmail::fromString(fake()->email),
        userPassword: UserPassword::fromString(fake()->password(5)),
        userRole: UserRole::editor,
    );

    expect($fakeEventBus->wasDispatched)->toBeTruthy()
        ->and($fakeEventBus->getEvents()[0])->toBeInstanceOf(UserCreated::class);
});
