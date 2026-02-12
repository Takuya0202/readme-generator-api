<?php

namespace App\Contexts\Auth\Domain\Repository;

use App\Models\User;

interface UserRepository
{
    public function existsUserByEmail(string $email): bool;
    public function create(array $data): User;
    public function findByEmail(string $email): User | null;
}
