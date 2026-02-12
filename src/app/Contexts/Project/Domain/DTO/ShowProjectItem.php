<?php

namespace App\Contexts\Project\Domain\DTO;

class ShowProjectItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $role,
        public readonly string $content,
        public readonly string $format,
    ) {}
}
