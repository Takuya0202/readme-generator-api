<?php

namespace App\Contexts\Project\Domain\Repository;

interface ProjectRepository
{
    public function getAllProjectsByUserId(int $userId): array;
}
