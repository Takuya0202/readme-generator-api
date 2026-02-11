<?php

namespace App\Contexts\Project\Domain\DTO;

class CreateProjectInput
{
    public function __construct(
        readonly public string $title,
        readonly public string $problem,
        readonly public int $people,
        readonly public string $period,
        readonly public string $stack,
        readonly public string $effort,
        readonly public string $trouble,
    ) {}
}
