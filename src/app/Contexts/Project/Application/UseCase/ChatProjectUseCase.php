<?php

namespace App\Contexts\Project\Application\UseCase;

use App\Contexts\Project\Domain\DTO\ChatProjectInput;
use App\Contexts\Project\Domain\Exception\FailedGenerateReadmeException;
use App\Contexts\Project\Domain\Exception\PermissionDeniedException;
use App\Contexts\Project\Domain\Exception\ProjectNotFoundException;
use App\Contexts\Project\Domain\Repository\MessageRepository;
use App\Contexts\Project\Domain\Repository\ProjectRepository;
use App\Contexts\Project\Domain\Service\GenerateReadmeService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChatProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly MessageRepository $messageRepository,
        private readonly GenerateReadmeService $generateReadmeService
    ) {}

    public function execute(ChatProjectInput $input, User $user): void
    {
        DB::transaction(function () use ($input, $user) {
            $project = $this->projectRepository->findById($input->projectId);
            if (!$project) {
                throw new ProjectNotFoundException();
            }

            if ($project->user_id !== $user->id) {
                throw new PermissionDeniedException();
            }

            $this->messageRepository->create([
                'project_id' => $input->projectId,
                'role' => 'user',
                'content' => $input->message,
                'format' => 'text',
            ]);

            $recentMessages = $this->messageRepository->getRecentMessages($input->projectId);

            try {
                $result = $this->generateReadmeService->generateWithContext(
                    name: $project->name,
                    problem: $project->problem,
                    people: $project->people,
                    period: $project->period,
                    stack: $project->stack,
                    effort: $project->effort,
                    trouble: $project->trouble,
                    messages: $recentMessages,
                    userMessage: $input->message
                );
            } catch (\Exception $e) {
                throw new FailedGenerateReadmeException();
            }

            $this->messageRepository->create([
                'project_id' => $input->projectId,
                'role' => 'assistant',
                'content' => $result->summary,
                'format' => 'text',
            ]);

            $this->messageRepository->create([
                'project_id' => $input->projectId,
                'role' => 'assistant',
                'content' => $result->markdown,
                'format' => 'markdown',
            ]);
        });
    }
}
