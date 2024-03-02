<?php

namespace App\Services\Users\Auth;

use App\Models\User;

class AuthUserAPIKeyService
{
    /**
     * @var User|null The User object representing the current logged-in user, or null if no user is logged in.
     */
    private $user;

    /**
     *
     * Initializes a new instance of the class.
     *
     * @param mixed $user The user object or data to be assigned to the class property.
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     *
     * Generates a new API key for the given name.
     *
     * @param string $name The name of the API key.
     * @return string The generated API key.
     */
    public function createAPIKey(string $name): string
    {
        return $this->user->createToken($name)->plainTextToken;
    }

    /**
     *
     * Deletes an API key based on the given ID.
     *
     * @param int $id The ID of the API key to be deleted.
     * @return void
     */
    public function deleteAPIKey(int $id): void
    {
        $this->user->tokens()->where('id', $id)->delete();
    }
}
