<?php

namespace App\Contexts\Project\Infrastructure\Repository;

use App\Contexts\Project\Domain\Repository\MessageRepository;
use App\Models\Message;

class EloquentMessageRepository implements MessageRepository
{
    public function create(array $data): Message
    {
        return Message::create($data);
    }
}
