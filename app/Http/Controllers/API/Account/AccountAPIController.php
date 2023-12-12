<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Spatie\Activitylog\Models\Activity;

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

    #[BodyParam("first_name", description: "First name of the user", example: "John")]
    #[BodyParam("last_name", description: "Last name of the user", example: "Doe")]
    #[BodyParam("username", description: "Username of the user", example: "johndoe")]
    #[BodyParam("email", description: "Email of the user", example: "john.doe@example")]
    #[BodyParam("language", description: "Language of the user", example: "en")]
    #[BodyParam("theme", description: "Theme of the user", example: "dark")]
    public function updateAccount(Request $request)
    {
        $user = $request->user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->language = $request->input('language');
        $user->theme = $request->input('theme');
        $user->save();

        return $request->user();
    }

}
