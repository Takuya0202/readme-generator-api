<?php

namespace App\Contexts\Project\Domain\DTO;

class CreateProjectInput
{
    public function __construct(
        readonly public string $title,
        readonly public string $problem,
    ) {}
}
