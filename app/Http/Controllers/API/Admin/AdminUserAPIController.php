<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\UserManager;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group('Admin', 'Admin Management')]
#[Subgroup('Users', 'Manage Users')]
#[Authenticated]
class AdminUserAPIController extends Controller
{
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    public function getUser(int $userId): User|JsonResponse
    {
        $user = UserManager::findUser($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return $user;
    }

    #[BodyParam('first_name', description: 'First name of the user', required: true, example: 'John')]
    #[BodyParam('last_name', description: 'Last name of the user', required: true, example: 'Doe')]
    #[BodyParam('username', description: 'Username of the user', required: true, example: 'johndoe')]
    #[BodyParam('email', description: 'Email of the user', required: true, example: 'john.doe@example')]
    #[BodyParam('language', description: 'Language of the user', required: false, example: 'en')]
    #[BodyParam('theme', description: 'Theme of the user', required: false, example: 'dark')]
    #[BodyParam('password', description: 'Password of the user', required: true, example: 'password')]
    #[BodyParam('groups', description: 'Roles of the user', required: false, example: ['Super Admin'])]
    #[BodyParam('permissions', description: 'Permissions of the user', required: false, example: ['update profile'])]
    public function createUser(Request $request): User
    {

        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'language' => 'nullable|string',
            'theme' => 'nullable|string',
            'password' => 'required|string',
            'groups' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'language' => $request->input('language'),
            'theme' => $request->input('theme'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($request->input('groups')) {
            $user->syncRoles($request->input('groups'));
        }

        if ($request->input('permissions')) {
            $user->syncPermissions($request->input('permissions'));
        }

        return $user;
    }

    #[BodyParam('first_name', description: 'First name of the user', required: false, example: 'John')]
    #[BodyParam('last_name', description: 'Last name of the user', required: false, example: 'Doe')]
    #[BodyParam('username', description: 'Username of the user', required: false, example: 'johndoe')]
    #[BodyParam('email', description: 'Email of the user', required: false, example: 'john.doe@example')]
    #[BodyParam('language', description: 'Language of the user', required: false, example: 'en')]
    #[BodyParam('theme', description: 'Theme of the user', required: false, example: 'dark')]
    #[BodyParam('password', description: 'Password of the user', required: false, example: 'password')]
    #[BodyParam('groups', description: 'Roles of the user', required: false, example: "['Super Admin']")]
    #[BodyParam('permissions', description: 'Permissions of the user', required: false, example: "['update profile']")]
    public function updateUser(Request $request, int $userId): User|JsonResponse
    {
        $user = UserManager::findUser($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $this->validate($request, [
            'first_name' => 'string',
            'last_name' => 'string',
            'username' => 'string|unique:users',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'language' => 'string',
            'theme' => 'string',
            'password' => 'string',
            'groups' => 'array',
            'permissions' => 'array',
        ]);

        $user->update([
            'first_name' => $request->input('first_name') ?? $user->first_name,
            'last_name' => $request->input('last_name') ?? $user->last_name,
            'username' => $request->input('username') ?? $user->username,
            'email' => $request->input('email') ?? $user->email,
            'language' => $request->input('language') ?? $user->language,
            'theme' => $request->input('theme') ?? $user->theme,
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
        ]);

        if ($request->input('groups')) {
            $user->syncRoles($request->input('groups'));
        }

        if ($request->input('permissions')) {
            $user->syncPermissions($request->input('permissions'));
        }

        return $user;
    }

    public function deleteUser(int $userId): JsonResponse
    {
        $user = UserManager::findUser($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        try {
            $user->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
