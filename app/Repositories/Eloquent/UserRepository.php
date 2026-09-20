<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function create(array $data): User
    {
        return $this->model->newQuery()->create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model
            ->newQuery()
            ->where('email', $email)
            ->first();
    }

    public function findById(int $id): ?User
    {
        return $this->model
            ->newQuery()
            ->find($id);
    }

    public function findByIdForUpdate(int $id): ?User
    {
        return $this->model
            ->newQuery()
            ->whereKey($id)
            ->lockForUpdate()
            ->first();
    }

    public function countMembers(): int
    {
        return $this->model
            ->newQuery()
            ->where('role', 'member')
            ->count();
    }

    public function countActiveMembers(): int
    {
        return $this->model
            ->newQuery()
            ->where('role', 'member')
            ->whereHas('activeSubscription')
            ->count();
    }

    public function getMembers(
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->with('activeSubscription.membershipPlan')
            ->where('role', 'member')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findMemberById(int $id): ?User
    {
        return $this->model
            ->newQuery()
            ->with([
                'activeSubscription.membershipPlan',
                'subscriptions.membershipPlan',
                'attendances.trainingSession',
                'payments.subscription.membershipPlan',
            ])
            ->where('role', 'member')
            ->find($id);
    }

    public function updateProfile(
        User $user,
        array $data
    ): User {
        $user->update($data);

        return $user->fresh();
    }

    public function updateMember(
        User $user,
        array $data
    ): User {
        $emailVerificationReset = array_key_exists(
            'email_verified_at',
            $data
        );

        if ($emailVerificationReset) {
            $emailVerifiedAt = $data['email_verified_at'];

            unset($data['email_verified_at']);

            $user->update($data);

            $user->forceFill([
                'email_verified_at' => $emailVerifiedAt,
            ])->save();
        } else {
            $user->update($data);
        }

        return $user->fresh();
    }

    public function updatePassword(
        User $user,
        string $password,
        string $rememberToken
    ): User {
        $user->forceFill([
            'password' => $password,
            'remember_token' => $rememberToken,
        ])->save();

        return $user->fresh();
    }
}
