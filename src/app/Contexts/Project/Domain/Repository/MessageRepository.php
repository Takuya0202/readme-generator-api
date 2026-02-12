<?php

namespace App\Contexts\Project\Domain\Repository;

use App\Models\Message;

interface MessageRepository
{
    public function create(array $data): Message;
}
