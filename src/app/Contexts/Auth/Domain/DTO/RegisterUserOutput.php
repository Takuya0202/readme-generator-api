<?php

namespace App\Contexts\Auth\Domain\DTO;

class RegisterUserOutput
{
    public function __construct(
        public string $token,
    ) {}
}
