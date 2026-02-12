<?php

namespace App\Contexts\Project\Domain\Repository;

use App\Models\Project;

interface ProjectRepository
{
    public function getAllProjectsByUserId(int $userId): array;
    public function create(array $data): Project;
    public function findById(string $id): ?Project;
}
