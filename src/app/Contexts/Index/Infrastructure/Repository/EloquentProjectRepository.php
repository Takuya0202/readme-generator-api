<?php

namespace App\Contexts\Index\Infrastructure\Repository;

use App\Contexts\Index\Domain\Repository\ProjectRepository;
use App\Models\Project;

class EloquentProjectRepository implements ProjectRepository
{
    public function getAllProjectsByUserId(int $userId): array
    {
        return Project::where('user_id', $userId)->get()->toArray();
    }
}
