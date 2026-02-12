<?php

namespace App\Contexts\Auth\Application\UseCase;

use App\Contexts\Auth\Domain\DTO\LoginUserInput;
use App\Contexts\Auth\Domain\DTO\LoginUserOutput;
use App\Contexts\Auth\Domain\Exception\InvalidCredentialsException;
use App\Contexts\Auth\Domain\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function execute(LoginUserInput $input): LoginUserOutput
    {
        $user = $this->userRepository->findByEmail($input->email);
        if (!$user || !Hash::check($input->password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        $token = $user->createToken("access_token")->plainTextToken;
        return new LoginUserOutput(
            token: $token
        );
    }
}
