<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contexts\Auth\Application\UseCase\LoginUserUseCase;
use App\Contexts\Auth\Domain\DTO\LoginUserInput;
use App\Contexts\Auth\Domain\Exception\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\Login as LoginRequest;
use App\Http\Responses\MutationResponse;
use Illuminate\Http\JsonResponse;

class Login extends Controller
{
    public function __construct(
        private readonly LoginUserUseCase $loginUserUseCase
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $input = new LoginUserInput(
                email: $request->email,
                password: $request->password
            );

            $output = $this->loginUserUseCase->execute($input);
            return MutationResponse::success(
                data: [
                    'token' => $output->token
                ],
                message: 'ログインに成功しました。',
            );
        } catch (InvalidCredentialsException $e) {
            return MutationResponse::error(
                message: $e->getMessage()
            );
        }
    }
}
