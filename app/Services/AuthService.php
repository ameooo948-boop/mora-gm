<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'member';

        return $this->userRepository->create($data);
    }

    public function attemptLogin(
        string $email,
        string $password,
        bool $remember = false
    ): bool {
        return Auth::attempt(
            [
                'email' => $email,
                'password' => $password,
            ],
            $remember
        );
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
