<?php

namespace App\Contexts\Index\Domain\Repository;

interface ProjectRepository
{
    public function getAllProjectsByUserId(int $userId): array;
}
