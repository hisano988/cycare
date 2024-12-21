<?php

namespace App\Infrastructure\RepositoryImpls;

use App\Domain\Models\User\User;
use App\Domain\Repositories\UserRepository;
use App\Infrastructure\Eloquents\EloquentUser;

class  UserRepositoryImpl implements UserRepository
{
    public function upsert(User $user, string $password): User
    {
        $eloquent = new EloquentUser();
        $eloquent->name = $user->getName();
        $eloquent->email = $user->getEmail();
        $eloquent->password = $password;
        $eloquent->save();

        $user->userId = $eloquent->userId;

        return $user;
    }
}
