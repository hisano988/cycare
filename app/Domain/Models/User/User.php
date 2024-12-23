<?php

namespace App\Domain\Models\User;

use App\Domain\Repositories\UserRepository;
use App\Exception\InvalidParameterException;
use Illminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class User
{
    public int $userId;

    private string $name;

    private string $email;

    private ?Carbon $emailVerifiedAt;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmailVerifiedAt(?Carbon $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function getEmailVerifiedAt(): ?Carbon
    {
        return $this->emailVerifiedAt;
    }

    public function register(string $rawPassword): self
    {
        // パスワードのハッシュ化処理
        $hashedPassword = Hash::make($rawPassword);

        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        // ユーザー登録処理
        $newUser = $userRepository->upsert($this);
        $userRepository->changePassword($this->userId, $hashedPassword);

        return $newUser;
    }

    public function updateProfile(string $name, string $email): self
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        // メールアドレスは重複禁止
        $sameEmailUsers = $userRepository->search($email);
        $isDuplicated = $sameEmailUsers->filter(function (User $user) {
            return $user->userId !== $this->userId;
        })->isNotEmpty();
        if ($isDuplicated) {
            throw new InvalidParameterException;
        }

        if ($this->email === $email) {
            $this->emailVerifiedAt = null;
        }
        $this->email = $email;
        $this->name = $name;

        return $userRepository->upsert($this);
    }

    public function unsubscribe(): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        $userRepository->delete($this->userId);
    }
}
