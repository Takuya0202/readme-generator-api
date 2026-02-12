<?php

namespace App\Contexts\Auth\Domain\DTO;

class RegisterUserInput
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
