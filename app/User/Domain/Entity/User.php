<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\Entity\AggregateRoot;
use App\User\Domain\Event\UserCreated;
use App\User\Domain\ValueObject\UserEmail;
use App\User\Domain\ValueObject\UserId;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserPassword;
use App\User\Domain\ValueObject\UserRole;
use Carbon\Carbon;

class User extends AggregateRoot
{
    private function __construct(
        private UserId $id,
        private UserName $name,
        private UserEmail $email,
        private UserPassword $password,
        private UserRole $role,
        private ?Carbon $emailVerifiedAt,
        private ?string $rememberToken,
        private Carbon $createdAt,
    ) {
    }

    public static function create(
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserRole $role,
    ): self {
        $user = new self(
            id: UserId::create(),
            name: $name,
            email: $email,
            password: $password,
            role: $role,
            emailVerifiedAt: null,
            rememberToken: null,
            createdAt: Carbon::now(),
        );

        $user->record(new UserCreated($user));

        return $user;
    }

    public static function fromPrimitives(mixed $user): self
    {
        return new self(
            id: UserId::fromString($user->id),
            name: UserName::fromString($user->name),
            email: UserEmail::fromString($user->email),
            password: UserPassword::fromString($user->password),
            role: UserRole::from($user->role),
            emailVerifiedAt: $user->emailVerifiedAt,
            rememberToken: $user->rememberToken,
            createdAt: $user->createdAt,
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function emailVerifiedAt(): ?Carbon
    {
        return $this->emailVerifiedAt;
    }

    public function rememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function createdAt(): Carbon
    {
        return $this->createdAt;
    }

    public function verified(): bool
    {
        return !is_null($this->emailVerifiedAt);
    }

    public function verify(): void
    {
        $this->emailVerifiedAt = Carbon::now();
    }
}
