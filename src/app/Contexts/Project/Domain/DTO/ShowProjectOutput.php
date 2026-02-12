<?php

namespace App\Contexts\Project\Domain\DTO;

class ShowProjectOutput
{
    /**
     * @param ShowProjectItem[] $data
     */
    public function __construct(
        public readonly array $data,
    ) {}
}
