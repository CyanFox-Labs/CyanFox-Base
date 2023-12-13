<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Spatie\Activitylog\Models\Activity;

#[Group("Admin", "Admin Management")]
#[Authenticated]
class AdminAPIController extends Controller
{

    public function getActivity()
    {
        $activity = Activity::all();

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

    public function getAdmins()
    {
        $users = User::all();
        return $users->filter(function ($user) {
            return $user->hasRole('Super Admin') || $user->hasRole('Admin');
        });
    }

}
