<?php

namespace App\Contexts\Project\Application\UseCase;

use App\Contexts\Project\Domain\DTO\ShowProjectItem;
use App\Contexts\Project\Domain\DTO\ShowProjectOutput;
use App\Contexts\Project\Domain\Exception\PermissionDeniedException;
use App\Contexts\Project\Domain\Exception\ProjectNotFoundException;
use App\Contexts\Project\Domain\Repository\ProjectRepository;
use App\Models\Message;
use App\Models\User;

class ShowProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository
    ) {}

    public function execute(string $id, User $user): ShowProjectOutput
    {
        $project = $this->projectRepository->findById($id);
        if (!$project) {
            throw new ProjectNotFoundException();
        }

        if ($project->user_id !== $user->id) {
            throw new PermissionDeniedException();
        }

        $data = $project->messages->map(function (Message $message) {
            return new ShowProjectItem(
                $message->id,
                $message->role,
                $message->content,
                $message->format,
            );
        })->toArray();

        return new ShowProjectOutput($data);
    }
}
