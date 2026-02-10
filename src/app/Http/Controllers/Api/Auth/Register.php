<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contexts\Auth\Application\UseCase\RegisterUserUseCase;
use App\Contexts\Auth\Domain\DTO\RegisterUserInput;
use App\Contexts\Auth\Domain\Exception\UserAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\Register as RegisterRequest;
use App\Http\Responses\MutationResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Register extends Controller
{
    public function __construct(
        private readonly RegisterUserUseCase $registerUserUseCase
    ) {}

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        Log::info('=== Register Controller Called ===');
        Log::info('Request data:', $request->all());
        try {
            $input = new RegisterUserInput(
                email: $request->email,
                password: $request->password
            );

            $output = $this->registerUserUseCase->execute($input);

            return MutationResponse::success(
                data: [
                    'token' => $output->token,
                ],
                message: "ユーザーの登録に成功しました。",
                statusCode: 201,
            );
        } catch (UserAlreadyExistsException $e) {
            return MutationResponse::error(
                $e->getMessage(),
                400,
            );
        }
    }
}
