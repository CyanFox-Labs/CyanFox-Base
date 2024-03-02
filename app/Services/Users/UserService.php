<?php

namespace App\Services\Users;

use App\Models\User;
use App\Services\Users\Auth\AuthUserService;

class UserService
{
    /**
     * Finds a user by their user ID.
     *
     * @param int $userId The ID of the user to find.
     *
     * @return User|null The found user, or null if no user is found.
     */
    public function findUser(int $userId): ?User
    {
        return User::find($userId);
    }

    /**
     * Finds a user by their username.
     *
     * @param string $username The username to search for.
     *
     * @return User|null The found user or null if no user is found.
     */
    public function findUserByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    /**
     * Find a user by email.
     *
     * @param string $email The email of the user to find.
     *
     * @return User|null The found user, or null if no user was found.
     */
    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Retrieves the OAuth manager instance.
     *
     * @return OAuthService The instance of the OAuth manager.
     */
    public function getOAuthManager(): OAuthService
    {
        return new OAuthService();
    }

    /**
     * Get the AuthUserService for the given User.
     *
     * @param User $user The User object.
     *
     * @return AuthUserService The AuthUserService for the given User.
     */
    public function getUser(User $user): AuthUserService
    {
        return new AuthUserService($user);
    }
}
