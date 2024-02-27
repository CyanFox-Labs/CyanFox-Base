<?php

namespace App\Services\Users\Auth;

class AuthUserAPIKeyService
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function createAPIKey(string $name): string
    {
        return $this->user->createToken($name)->plainTextToken;
    }

    public function deleteAPIKey(int $id): void
    {
        $this->user->tokens()->where('id', $id)->delete();
    }
}
