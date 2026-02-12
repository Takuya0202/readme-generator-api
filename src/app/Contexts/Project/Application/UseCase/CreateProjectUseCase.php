<?php

namespace App\Contexts\Project\Application\UseCase;

use App\Contexts\Project\Domain\DTO\CreateProjectInput;
use App\Contexts\Project\Domain\DTO\CreateProjectOutput;
use App\Contexts\Project\Domain\Exception\FailedGenerateReadmeException;
use App\Contexts\Project\Domain\Repository\MessageRepository;
use App\Contexts\Project\Domain\Repository\ProjectRepository;
use App\Contexts\Project\Domain\Service\GenerateReadmeService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly MessageRepository $messageRepository,
        private readonly GenerateReadmeService $generateReadmeService
    ) {}

    public function execute(CreateProjectInput $input, User $user): CreateProjectOutput
    {
        return DB::transaction(function () use ($input, $user) {
            $uuid = Str::uuid()->toString();
            $project = $this->projectRepository->create([
                'id' => $uuid,
                'user_id' => $user->id,
                'name' => $input->name,
                'problem' => $input->problem,
                'people' => $input->people,
                'period' => $input->period,
                'stack' => $input->stack,
                'effort' => $input->effort,
                'trouble' => $input->trouble,
            ]);

            try {
                $result = $this->generateReadmeService->generate(
                    $input->name,
                    $input->problem,
                    $input->people,
                    $input->period,
                    $input->stack,
                    $input->effort,
                    $input->trouble,
                );
            } catch (\Exception $e) {
                throw new FailedGenerateReadmeException();
            }

            // summaryを格納
            $this->messageRepository->create([
                'project_id' => $project->id,
                'role' => 'assistant',
                'content' => $result->summary,
                'format' => 'text',
            ]);

            // markdownを格納
            $this->messageRepository->create([
                'project_id' => $project->id,
                'role' => 'assistant',
                'content' => $result->markdown,
                'format' => 'markdown',
            ]);

            return new CreateProjectOutput($project->id);
        });
    }
}
