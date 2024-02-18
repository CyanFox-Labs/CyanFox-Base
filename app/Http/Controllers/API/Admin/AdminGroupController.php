<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Spatie\Permission\Models\Role;

#[Group("Admin", "Admin Management")]
#[Subgroup("Groups", "Manage Groups")]
#[Authenticated]
class AdminGroupController extends Controller
{

    public function getAllGroups()
    {
        return Role::all();
    }

    public function getGroup($userId)
    {
        $group = Role::find($userId);

        if (!$group) {
            return response()->json([
                'message' => 'Group not found',
            ], 404);
        }

        return $group;
    }

    #[BodyParam("name", description: "Name of the group", example: "Super Admin")]
    #[BodyParam("guard_name", description: "Guard name of the group", example: "web")]
    #[BodyParam("permissions", description: "Permissions of the group", example: ['create user'])]
    public function createGroup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $group = new Role();
        $group->name = $request->input('name');
        $group->guard_name = $request->input('guard_name');

        try {
            $group->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create group',
                'error' => $e->getMessage(),
            ], 500);
        }

        if ($request->input('permissions')) {
            $group->syncPermissions($request->input('permissions'));
        }

        return $group;
    }

    #[BodyParam("name", description: "Name of the group", example: "Super Admin")]
    #[BodyParam("guard_name", description: "Guard name of the group", example: "web")]
    #[BodyParam("permissions", description: "Permissions of the group", example: ['create user'])]
    public function updateGroup(Request $request, $userId)
    {
        $group = Role::find($userId);

        if (!$group) {
            return response()->json([
                'message' => 'Group not found',
            ], 404);
        }

        $this->validate($request, [
            'name' => 'required|string',
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $group->name = $request->input('name');
        $group->guard_name = $request->input('guard_name');

        try {
            $group->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update group',
                'error' => $e->getMessage(),
            ], 500);
        }

        if ($request->input('permissions')) {
            $group->syncPermissions($request->input('permissions'));
        }

        return $group;
    }

    public function deleteGroup($userId)
    {
        $group = Role::find($userId);
        if (!$group) {
            return response()->json([
                'message' => 'Group not found'
            ], 404);
        }

        $group->delete();
        return response()->json([
            'message' => 'Group deleted'
        ]);
    }
}
