<?php

namespace App\Contexts\Project\Domain\Service;

use App\Contexts\Project\Domain\DTO\GenerateReadmeOutput;

interface GenerateReadmeService
{
    public function generate(
        string $name,
        string $problem,
        int $people,
        string $period,
        string $stack,
        ?string $effort,
        ?string $trouble,
    ): GenerateReadmeOutput;
}
