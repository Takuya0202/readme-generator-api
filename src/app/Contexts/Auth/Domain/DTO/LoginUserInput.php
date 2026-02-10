<?php

namespace App\Contexts\Auth\Domain\DTO;

class LoginUserInput
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
