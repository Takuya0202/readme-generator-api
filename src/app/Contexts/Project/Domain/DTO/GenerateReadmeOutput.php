<?php

namespace App\Contexts\Project\Domain\DTO;

class GenerateReadmeOutput
{
    public function __construct(
        public string $summary,
        public string $markdown,
    ) {}
}
