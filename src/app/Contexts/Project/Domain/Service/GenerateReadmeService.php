<?php

namespace App\Contexts\Project\Domain\Service;

use App\Contexts\Project\Domain\DTO\GenerateReadmeOutput;

interface GenerateReadmeServiceInterface
{
    public function generate(
        string $title,
        string $problem,
        int $people,
        string $period,
        string $stack,
        string $effort,
        string $trouble,
    ): GenerateReadmeOutput;
}
