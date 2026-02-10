<?php

namespace App\Contexts\Auth\Application\UseCase;

use App\Models\User;

class LogoutUserUseCase
{
    public function execute(User $user): void
    {
        // エラー出てるけど、トークンが存在しない場合などはミドルウェアで弾かれるはずなので問題ない
        $user->currentAccessToken()?->delete();
    }
}
