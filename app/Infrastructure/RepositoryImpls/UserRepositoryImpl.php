<?php

namespace App\Infrastructure\RepositoryImpls;

use App\Domain\Models\User\User;
use App\Domain\Repositories\UserRepository;
use App\Infrastructure\Eloquents\EloquentUser;
use Illuminate\Support\Collection;

class UserRepositoryImpl implements UserRepository
{
    public function find(int $userId): ?User
    {
        $eloquent = EloquentUser::find($userId);
        if (is_null($eloquent)) {
            return null;
        }

        return $this->newUser($eloquent);
    }

    public function search(string $email): Collection
    {
        $eloquents = EloquentUser::where('email', $email)->get();
        $users = collect();
        foreach ($eloquents as $eloquent) {
            $users->push($this->newUser($eloquent));
        }

        return $users;
    }

    public function upsert(User $user): User
    {
        $eloquent = new EloquentUser;
        $eloquent->name = $user->getName();
        $eloquent->email = $user->getEmail();
        $eloquent->email_verified_at = $user->getEmailVerifiedAt();
        $eloquent->save();

        $user->userId = $eloquent->userId;

        return $user;
    }

    public function changePassword(int $userId, string $hashedPassword): void
    {
        $eloquent = EloquentUser::find($userId);
        $eloquent->password = $hashedPassword;
        $eloquent->save();
    }

    public function delete(int $userId): void
    {
        EloquentUser::destroy($userId);
    }

    private function newUser(EloquentUser $user): User
    {
        $newUser = new User($user->name, $user->email);
        $newUser->userId = $user->user_id;
        $newUser->setEmailVerifiedAt($user->emailVerifiedAt);

        return $newUser;
    }
}
