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

    public function getRecentMessages(string $projectId): array
    {
        return Message::where('project_id', $projectId)
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get()
            ->map(fn(Message $message) => [
                'id' => $message->id,
                'role' => $message->role,
                'content' => $message->content,
                'format' => $message->format,
            ])
            ->toArray();
    }
}
