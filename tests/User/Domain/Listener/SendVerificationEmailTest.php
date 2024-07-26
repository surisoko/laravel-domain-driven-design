<?php

namespace Tests\User\Domain\Listener;

use App\User\Domain\Listener\SendVerificationEmail;
use App\User\Domain\Service\FakeEmailDeliveryService;
use App\User\Infrastructure\Model\User as EloquentUser;
use App\User\Infrastructure\Parser\ParseUserToDomain;
use App\User\Infrastructure\Repository\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('send verification email to a new user', function () {
    $fakeEmailDeliveryService = new FakeEmailDeliveryService();
    $eloquentUser = EloquentUser::factory()->create();
    $user = ParseUserToDomain::fromEloquent($eloquentUser);

    $sendVerificationEmail = new SendVerificationEmail(
        new EloquentUserRepository(),
        $fakeEmailDeliveryService
    );
    $sendVerificationEmail->execute($user->id());

    expect($fakeEmailDeliveryService->emailWasSent)->toBeTruthy()
        ->and($fakeEmailDeliveryService->email->equals($user->email()))->toBeTruthy();
});
