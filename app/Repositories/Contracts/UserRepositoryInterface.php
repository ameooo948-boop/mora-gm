<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function findByEmail(string $email): ?User;

    public function findById(int $id): ?User;

    public function findByIdForUpdate(int $id): ?User;

    public function countMembers(): int;

    public function countActiveMembers(): int;

    public function getMembers(
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findMemberById(int $id): ?User;

    public function updateProfile(
        User $user,
        array $data
    ): User;

    public function updateMember(
        User $user,
        array $data
    ): User;

    public function updatePassword(
        User $user,
        string $password,
        string $rememberToken
    ): User;
}
