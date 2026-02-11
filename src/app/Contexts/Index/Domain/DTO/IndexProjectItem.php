<?php

namespace App\Contexts\Index\Domain\DTO;

class IndexProjectItem
{
    public function __construct(
        public string $id,
        public string $name
    ) {}
}
