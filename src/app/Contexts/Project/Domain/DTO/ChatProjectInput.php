<?php

namespace App\Contexts\Project\Domain\DTO;

class ChatProjectInput
{
    public function __construct(
        public readonly string $projectId,
        public readonly string $message,
    ) {}
}
