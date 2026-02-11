<?php

namespace App\Contexts\Index\Domain\DTO;

use App\Contexts\Index\Domain\DTO\IndexProjectItem;

class IndexProjectOutput
{
    /**
     * @param IndexProjectItem[] $data
     */
    public function __construct(
        readonly public array $data
    ) {}
}
