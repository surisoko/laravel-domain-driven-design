<?php

namespace Tests\User\Infrastructure\Listener;

use App\User\Domain\Event\UserCreated;
use App\User\Domain\Listener\SendVerificationEmail;
use App\User\Domain\Service\FakeEmailDeliveryService;
use App\User\Infrastructure\Listener\SendVerificationEmailSubscriber;
use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use App\User\Infrastructure\Repository\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('send verification email to a new user', function () {
    $eloquentUser = EloquentUser::factory()->create();
    $user = ParseUserToDomain::fromEloquent($eloquentUser);
    $fakeEmailDeliveryService = new FakeEmailDeliveryService();
    $sendVerificationEmail = new SendVerificationEmail(
        new EloquentUserRepository(),
        $fakeEmailDeliveryService
    );
    $sendVerificationEmailSubscriber = new SendVerificationEmailSubscriber($sendVerificationEmail);

    $sendVerificationEmailSubscriber->handle(new UserCreated($user));

    expect($fakeEmailDeliveryService->emailWasSent)->toBeTruthy()
    ->and($fakeEmailDeliveryService->email->equals($user->email()))->toBeTruthy();
});
