<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Spatie\Activitylog\Models\Activity;
use function Symfony\Component\String\u;

#[Group("User Account", "User Account Management")]
#[Authenticated]
class AccountAPIController extends Controller
{

    public function getAccount(Request $request)
    {
        return $request->user();
    }

    public function getActivity(Request $request)
    {
        $activity = Activity::where('subject_id', $request->user()->id)->get();

        return $activity->map(function ($item) {
            return [
                'id' => $item->id,
                'description' => $item->description,
                'subject_id' => $item->subject_id,
                'subject_type' => $item->subject_type,
                'causer_id' => $item->causer_id,
                'causer_type' => $item->causer_type,
                'name' => $item->properties['name'],
                'ip' => $item->properties['ip'],
                'properties' => $item->properties,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
    }

    public function getPermissions(Request $request)
    {
        return $request->user()->getAllPermissions();
    }

    public function getRoles(Request $request)
    {
        return $request->user()->getRoleNames();
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
        $user = $request->user();
        if ($request->input('first_name')) $user->first_name = $request->input('first_name');
        if ($request->input('last_name')) $user->last_name = $request->input('last_name');
        if ($request->input('username')) $user->username = $request->input('username');
        if ($request->input('email')) $user->email = $request->input('email');

        if ($request->input('language')) $user->language = $request->input('language');
        if ($request->input('theme')) $user->theme = $request->input('theme');
        if ($request->input('password')) $user->password = bcrypt($request->input('password'));
        $user->save();

        return $request->user();
    }

}
