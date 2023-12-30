<?php

namespace App\Http\Controllers\API\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Spatie\Activitylog\Models\Activity;

#[Group("Admin", "Admin Management")]
#[Subgroup("Users", "Manage Users")]
#[Authenticated]
class AdminUserAPIController extends Controller
{

    public function getAllUsers()
    {
        return User::all();
    }

    public function getUser($userId)
    {
        return User::find($userId);
    }

    #[BodyParam("first_name", description: "First name of the user", required: true, example: "John")]
    #[BodyParam("last_name", description: "Last name of the user", required: true, example: "Doe")]
    #[BodyParam("username", description: "Username of the user", required: true, example: "johndoe")]
    #[BodyParam("email", description: "Email of the user", required: true, example: "john.doe@example")]
    #[BodyParam("language", description: "Language of the user", required: false, example: "en")]
    #[BodyParam("theme", description: "Theme of the user", required: false, example: "dark")]
    #[BodyParam("password", description: "Password of the user", required: true, example: "password")]
    #[BodyParam("roles", description: "Roles of the user", required: false, example: "['Super Admin']")]
    public function createUser(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'language' => 'nullable|string',
            'theme' => 'nullable|string',
            'password' => 'required|string',
            'roles' => 'nullable|array',
        ]);

        $user = new User();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->input('language')) $user->language = $request->input('language');
        if ($request->input('theme')) $user->theme = $request->input('theme');
        $user->password = bcrypt($request->input('password'));

        try {
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'errors' => [
                    'user' => $e->getMessage(),
                ],
            ], 500);
        }

        if ($request->input('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        $user->save();
        return $user;
    }

    #[BodyParam("first_name", description: "First name of the user", required: false, example: "John")]
    #[BodyParam("last_name", description: "Last name of the user", required: false, example: "Doe")]
    #[BodyParam("username", description: "Username of the user", required: false, example: "johndoe")]
    #[BodyParam("email", description: "Email of the user", required: false, example: "john.doe@example")]
    #[BodyParam("language", description: "Language of the user", required: false, example: "en")]
    #[BodyParam("theme", description: "Theme of the user", required: false, example: "dark")]
    #[BodyParam("password", description: "Password of the user", required: false, example: "password")]
    #[BodyParam("roles", description: "Roles of the user", required: false, example: "['Super Admin']")]
    public function updateUser($userId, Request $request)
    {

        $this->validate($request, [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'nullable|string|unique:users',
            'email' => 'nullable|email|unique:users',
            'language' => 'nullable|string',
            'theme' => 'nullable|string',
            'password' => 'nullable|string',
            'roles' => 'nullable|array',
        ]);

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($request->input('first_name')) $user->first_name = $request->input('first_name');
        if ($request->input('last_name')) $user->last_name = $request->input('last_name');
        if ($request->input('username')) $user->username = $request->input('username');
        if ($request->input('email')) $user->email = $request->input('email');

        if ($request->input('language')) $user->language = $request->input('language');
        if ($request->input('theme')) $user->theme = $request->input('theme');
        if ($request->input('password')) $user->password = bcrypt($request->input('password'));

        try {
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update user',
                'errors' => [
                    'user' => $e->getMessage(),
                ],
            ], 500);
        }

        if ($request->input('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        return $user;
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        try {
            $user->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user',
                'errors' => [
                    'user' => $e->getMessage(),
                ],
            ], 500);
        }

        return response()->json([
            'message' => 'User successfully deleted'
        ]);
    }

}
