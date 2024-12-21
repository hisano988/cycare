<?php

namespace App\Domain\Repositories;

use App\Domain\Models\User\User;

interface UserRepository
{
    public function upsert(User $user, string $password): User;
}
