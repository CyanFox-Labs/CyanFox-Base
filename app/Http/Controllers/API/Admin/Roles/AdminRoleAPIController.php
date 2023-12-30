<?php

namespace App\Http\Controllers\API\Admin\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

#[Group("Admin", "Admin Management")]
#[Subgroup("Roles", "Manage Roles")]
#[Authenticated]
class AdminRoleAPIController extends Controller
{

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRole($userId)
    {
        return Role::find($userId);
    }

    #[BodyParam("name", description: "Name of the role", example: "Super Admin")]
    #[BodyParam("guard_name", description: "Guard name of the role", example: "web")]
    #[BodyParam("permissions", description: "Permissions of the role", example: "['create user']")]
    public function createRole(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'guard_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard_name');

        try {
            $role->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create role',
                'errors' => [
                    'role' => $e->getMessage(),
                ],
            ], 500);
        }

        if ($request->input('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return $role;
    }

    #[BodyParam("name", description: "Name of the role", required: false, example: "Super Admin")]
    #[BodyParam("guard_name", description: "Guard name of the role", required: false, example: "web")]
    #[BodyParam("permissions", description: "Permissions of the role", required: false, example: "['create user']")]
    public function updateRole($roleId, Request $request)
    {

        $this->validate($request, [
            'name' => 'nullable|string',
            'guard_name' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::find($roleId);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        if ($request->input('name')) $role->name = $request->input('name');
        if ($request->input('guard_name')) $role->guard_name = $request->input('guard_name');

        try {
            $role->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update role',
                'errors' => [
                    'role' => $e->getMessage(),
                ],
            ], 500);
        }

        if ($request->input('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return $role;
    }

    public function deleteRole($roleId)
    {
        $role = Role::find($roleId);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        try {
            $role->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete role',
                'errors' => [
                    'role' => $e->getMessage(),
                ],
            ], 500);
        }

        return response()->json([
            'message' => 'Role successfully deleted'
        ]);
    }

}
