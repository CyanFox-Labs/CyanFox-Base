<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\GroupManager;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Spatie\Permission\Models\Role;

#[Group('Admin', 'Admin Management')]
#[Subgroup('Groups', 'Manage Groups')]
#[Authenticated]
class AdminGroupController extends Controller
{
    public function getAllGroups(): Collection
    {
        return Role::all();
    }

    public function getGroup(int $groupId): Role|JsonResponse
    {
        $group = GroupManager::findGroup($groupId);

        if (!$group) {
            return response()->json([
                'message' => 'Group not found',
            ], 404);
        }

        return $group;
    }

    #[BodyParam('name', description: 'Name of the group', example: 'Super Admin')]
    #[BodyParam('guard_name', description: 'Guard name of the group', example: 'web')]
    #[BodyParam('permissions', description: 'Permissions of the group', example: ['create user'])]
    public function createGroup(Request $request): Role
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $group = Role::create([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);

        if ($request->input('permissions')) {
            $group->syncPermissions($request->input('permissions'));
        }

        return $group;
    }

    #[BodyParam('name', description: 'Name of the group', example: 'Super Admin')]
    #[BodyParam('guard_name', description: 'Guard name of the group', example: 'web')]
    #[BodyParam('permissions', description: 'Permissions of the group', example: ['create user'])]
    public function updateGroup(Request $request, int $groupId): Role|JsonResponse
    {
        $group = GroupManager::findGroup($groupId);

        if (!$group) {
            return response()->json([
                'message' => 'Group not found',
            ], 404);
        }

        $this->validate($request, [
            'name' => 'required|string|unique:roles,name,'.$group->id,
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $group->update([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);

        if ($request->input('permissions')) {
            $group->syncPermissions($request->input('permissions'));
        }

        return $group;
    }

    public function deleteGroup(int $groupId): JsonResponse
    {
        $group = GroupManager::findGroup($groupId);

        if (!$group) {
            return response()->json([
                'message' => 'Group not found',
            ], 404);
        }

        $group->delete();

        return response()->json([
            'message' => 'Group deleted',
        ]);
    }
}
