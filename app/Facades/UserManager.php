<?php

namespace App\Facades;

use App\Models\User;
use App\Services\Users\Auth\AuthUserService;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static User getAllUsers()
 * @method static User findUser(int $userId)
 * @method static User findUserByUsername(string $username)
 * @method static User findUserByEmail(string $email)
 * @method static User createUser(array $data)
 * @method static User updateUser(User $user, array $data)
 * @method static void deleteUser(User $user)
 * @method static AuthUserService getUser(User $user)
 */
class UserManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserService::class;
    }

}
