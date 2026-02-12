<?php

namespace App\Contexts\Project\Domain\DTO;

class CreateProjectOutput
{
    public function __construct(
        readonly public string $id,
    ) {}
}
