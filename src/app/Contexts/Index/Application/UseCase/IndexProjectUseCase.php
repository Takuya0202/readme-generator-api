<?php

namespace App\Contexts\Index\Application\UseCase;

use App\Contexts\Index\Domain\DTO\IndexProjectItem;
use App\Contexts\Index\Domain\DTO\IndexProjectOutput;
use App\Contexts\Index\Domain\Repository\ProjectRepository;
use App\Models\User;

class IndexProjectUseCase
{
    public function __construct(
        readonly private ProjectRepository $projectRepository
    ) {}

    public function execute(User $user): IndexProjectOutput
    {
        $projects = $this->projectRepository->getAllProjectsByUserId($user->id);
        $data = array_map(function ($item) {
            return new IndexProjectItem($item['id'], $item['name']);
        }, $projects);
        return new IndexProjectOutput($data);
    }
}
