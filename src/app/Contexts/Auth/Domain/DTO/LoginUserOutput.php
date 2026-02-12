<?php

namespace App\Contexts\Auth\Domain\DTO;

class LoginUserOutput
{
    public function __construct(
        public readonly string $token,
    ) {}
}
