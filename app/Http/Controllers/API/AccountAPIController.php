<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;

#[Authenticated]
#[Group('Account', 'Account Management')]
class AccountAPIController extends Controller
{

    public function getAccount(Request $request)
    {
        return $request->user();
    }

    public function getActivity(Request $request)
    {
        return ActivityLog::query()->where('performed_by', $request->user()->id)->orderByDesc('created_at')->get();
    }

    public function getPermissions(Request $request)
    {
        return $request->user()->getAllPermissions();
    }

    public function getGroups(Request $request)
    {
        return $request->user()->getRoleNames();
    }

    public function getAvatar(Request $request)
    {
        return $request->user()->getAvatarURL();
    }

    public function deleteAccount(Request $request)
    {
        $request->user()->delete();
        return response()->json(['message' => 'Account deleted']);
    }

    #[BodyParam("first_name", description: "First name of the user", required: false, example: "John")]
    #[BodyParam("last_name", description: "Last name of the user", required: false, example: "Doe")]
    #[BodyParam("username", description: "Username of the user", required: false, example: "johndoe")]
    #[BodyParam("email", description: "Email of the user", required: false, example: "john.doe@example")]
    #[BodyParam("language", description: "Language of the user", required: false, example: "en")]
    #[BodyParam("theme", description: "Theme of the user", required: false, example: "dark")]
    #[BodyParam("password", description: "Password of the user", required: false, example: "password")]
    public function updateAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'username' => 'string|nullable',
            'email' => 'email|nullable',
            'language' => 'string|nullable',
            'theme' => 'string|nullable',
            'password' => 'string|nullable',
        ]);

        $user = $request->user();
        if ($request->input('first_name')) $user->first_name = $request->input('first_name');
        if ($request->input('last_name')) $user->last_name = $request->input('last_name');
        if ($request->input('username')) $user->username = $request->input('username');
        if ($request->input('email')) $user->email = $request->input('email');

        if ($request->input('language')) $user->language = $request->input('language');
        if ($request->input('theme')) $user->theme = $request->input('theme');
        if ($request->input('password')) $user->password = Hash::make($request->input('password'));

        try {
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update profile',
                'error' => $e->getMessage(),
            ], 500);
        }

        return $request->user();
    }
}
