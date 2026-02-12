<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Contexts\Auth\Application\UseCase\LogoutUserUseCase;
use App\Http\Responses\MutationResponse;

class Logout extends Controller
{
    public function __construct(
        private readonly LogoutUserUseCase $logoutUserUseCase
    ) {}
    public function __invoke(Request $request): JsonResponse
    {
        $this->logoutUserUseCase->execute($request->user());
        return MutationResponse::success(
            message: 'ログアウトしました。'
        );
    }
}
