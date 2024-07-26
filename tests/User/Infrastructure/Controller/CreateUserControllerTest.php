<?php

namespace Tests\User\Infrastructure\Controller;

use App\Shared\Domain\Event\EventBus;
use App\Shared\Infrastructure\Event\FakeEventBus;
use App\User\Domain\Event\UserCreated;
use App\User\Domain\Exception\InvalidUserEmail;
use App\User\Domain\Exception\InvalidUserName;
use App\User\Domain\Exception\InvalidUserPassword;
use App\User\Domain\Exception\InvalidUserRole;
use App\User\Domain\Exception\UserAlreadyExists;
use App\User\Domain\ValueObject\UserRole;
use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('create a new user', function () {
    $fakeEventBus = new FakeEventBus(); // or use Laravel Event::fake();
    $this->app->instance(EventBus::class, $fakeEventBus);
    Carbon::setTestNow($now = Carbon::now());

    $this->postJson(route('create.user', [
        'email' => $email = fake()->email,
        'name' => $name = fake()->firstName,
        'password' => $password = fake()->password(5),
        'role' => UserRole::editor->value,
    ]))->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'email' => $email,
        'name' => $name,
        'email_verified_at' => null,
        'role' => UserRole::editor->value,
        'remember_token' => null,
        'created_at' => $now
    ]);
    $user = EloquentUser::query()->where('email', '=', $email)->first();
    expect(Hash::check($password, $user->password))->toBeTruthy()
    ->and($fakeEventBus->wasDispatched)->toBeTruthy()->and
    ($fakeEventBus->getEvents()[0])->toBeInstanceOf(UserCreated::class);
});

test('return unprocessable entity if user name is to short', function () {
    $response = $this->postJson(route('create.user', [
        'email' => fake()->email,
        'name' => fake()->randomLetter,
        'password' => fake()->password(5),
        'role' => UserRole::editor->value,
    ]))->assertStatus(422)->decodeResponseJson();

    expect(InvalidUserName::nameIsToShort()->getMessage())->toEqual($response['message']);
});

test('return unprocessable entity if role is not valid', function () {
    $response = $this->postJson(route('create.user', [
        'email' => fake()->email,
        'name' => fake()->firstName,
        'password' => fake()->password(5),
        'role' => fake()->word(),
    ]))->assertStatus(422)->decodeResponseJson();

    expect(InvalidUserRole::notAllowed()->getMessage())->toEqual($response['message']);
});

test('return unprocessable entity if user name has numbers', function () {
    $response = $this->postJson(route('create.user', [
        'email' => fake()->email,
        'name' => fake()->numberBetween(),
        'password' => fake()->password(5),
        'role' => UserRole::editor->value,
    ]))->assertStatus(422)->decodeResponseJson();

    expect(InvalidUserName::onlyCharacters()->getMessage())->toEqual($response['message']);
});

test('return unprocessable entity if user email is not valid', function () {
    $response = $this->postJson(route('create.user', [
        'email' => fake()->word,
        'name' => fake()->firstName,
        'password' => fake()->password(5),
        'role' => UserRole::editor->value,
    ]))->assertStatus(422)->decodeResponseJson();

    expect(InvalidUserEmail::execute()->getMessage())->toEqual($response['message']);
});

test('return unprocessable entity if user password is less than 5 characters', function () {
    $response = $this->postJson(route('create.user', [
        'email' => fake()->email,
        'name' => fake()->firstName,
        'password' => fake()->password(1, 4),
        'role' => UserRole::editor->value,
    ]))->assertStatus(422)->decodeResponseJson();

    expect(InvalidUserPassword::toShort()->getMessage())->toEqual($response['message']);
});

test('return conflict if user already exists', function () {
    $eloquentUser = EloquentUser::factory()->create();
    $user = ParseUserToDomain::fromEloquent($eloquentUser);

    $response = $this->postJson(route('create.user', [
        'email' => $user->email()->getValue(),
        'name' => $user->name()->getValue(),
        'password' => $user->password()->getValue(),
        'role' => UserRole::editor->value,
    ]))->assertStatus(409)->decodeResponseJson();

    expect(UserAlreadyExists::execute($user)->getMessage())->toEqual($response['message']);
});
