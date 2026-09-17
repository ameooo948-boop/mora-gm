<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function getMembers(
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getMembers(
            $search,
            $perPage
        );
    }

    public function getMember(int $id): ?User
    {
        return $this->repository->findMemberById($id);
    }

    public function updateProfile(
        User $user,
        array $data
    ): User {
        return $this->repository->updateProfile(
            $user,
            $data
        );
    }
}
