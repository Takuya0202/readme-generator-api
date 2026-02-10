<?php

namespace App\Contexts\Auth\Infrastructure\Repository;

use App\Contexts\Auth\Domain\Repository\UserRepository;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{
    public function existsUserByEmail(string $email): bool
    {
        return User::where("email", $email)->exists();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }
}
