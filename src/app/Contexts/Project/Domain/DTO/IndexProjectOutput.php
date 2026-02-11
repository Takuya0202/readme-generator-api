<?php

namespace App\Contexts\Project\Domain\DTO;

use App\Contexts\Project\Domain\DTO\IndexProjectItem;

class IndexProjectOutput
{
    /**
     * @param IndexProjectItem[] $data
     */
    public function __construct(
        readonly public array $data
    ) {}
}
