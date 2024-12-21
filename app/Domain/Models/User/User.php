<?php

namespace App\Domain\Models\User;

use Illuminate\Support\Facades\Hash;
use App\Domain\Repositories\UserRepository;

class User
{
    public int $userId;

    private string $name;

    private string $email;

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

    public function register(string $rawPassword): self
    {
        // パスワードのハッシュ化処理
        $hashedPassword = Hash::make($rawPassword);

        // ユーザー登録処理
        return app(UserRepository::class)->upsert($this, $hashedPassword);
    }
}
