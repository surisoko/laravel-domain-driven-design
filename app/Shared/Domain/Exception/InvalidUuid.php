<?php

namespace App\Shared\Domain\Exception;

class InvalidUuid extends \Exception
{
    public static function execute(mixed $uuid): self
    {
        return new self("Invalid id {$uuid}");
    }
}
