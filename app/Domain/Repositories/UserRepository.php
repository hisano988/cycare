<?php

namespace App\Domain\Repositories;

use App\Domain\Models\User\User;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function find(int $userId): ?User;

    /**
     * @return Collection<User>
     */
    public function search(string $email): Collection;

    public function upsert(User $user): User;

    public function changePassword(int $userId, string $hashedPassword): void;

    public function delete(int $userId): void;
}
