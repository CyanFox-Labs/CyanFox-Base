<?php

namespace App\Services\Users;

use App\Models\User;
use App\Services\Users\Auth\AuthUserService;
use Illuminate\Support\Collection;

class UserService
{
    public function getAllUsers(): Collection
    {
        return User::all();
    }


    public function findUser(int $userId): ?User
    {
        return User::find($userId);
    }

    public function findUserByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getUser(User $user): AuthUserService
    {
        return new AuthUserService($user);
    }
}
