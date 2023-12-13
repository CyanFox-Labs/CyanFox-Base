<?php

namespace App\Http\Controllers\API\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $user->save();

        if ($request->input('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        return $user;
    }

    #[BodyParam("first_name", description: "First name of the user", example: "John")]
    #[BodyParam("last_name", description: "Last name of the user", example: "Doe")]
    #[BodyParam("username", description: "Username of the user", example: "johndoe")]
    #[BodyParam("email", description: "Email of the user", example: "john.doe@example")]
    #[BodyParam("language", description: "Language of the user", required: false, example: "en")]
    #[BodyParam("theme", description: "Theme of the user", required: false, example: "dark")]
    #[BodyParam("password", description: "Password of the user", required: false, example: "password")]
    #[BodyParam("roles", description: "Roles of the user", required: false, example: "['Super Admin']")]
    public function createUser(Request $request)
    {
        $user = new User();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->input('language')) $user->language = $request->input('language');
        if ($request->input('theme')) $user->theme = $request->input('theme');
        if ($request->input('password')) $user->password = bcrypt($request->input('password'));
        $user->save();

        if ($request->input('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        $user->save();
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

        $user->delete();

        return response()->json([
            'message' => 'User successfully deleted'
        ]);
    }

}
