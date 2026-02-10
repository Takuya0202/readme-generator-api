<?php

namespace App\Contexts\Auth\Application\UseCase;

use App\Contexts\Auth\Domain\DTO\RegisterUserInput;
use App\Contexts\Auth\Domain\DTO\RegisterUserOutput;
use App\Contexts\Auth\Domain\Exception\UserAlreadyExistsException;
use App\Contexts\Auth\Domain\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function execute(RegisterUserInput $input): RegisterUserOutput
    {
        if ($this->userRepository->existsUserByEmail($input->email)) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->userRepository->create([
            'email' => $input->email,
            'password' => Hash::make($input->password)
        ]);

        $token = $user->createToken('access_token')->plainTextToken;
        return new RegisterUserOutput(
            token: $token,
        );
    }
}
