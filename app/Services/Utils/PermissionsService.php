<?php

namespace App\Services\Utils;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsService
{
    public function createPermissions($moduleName, $permissions = [], $cacheDuration = 'forever'): void
    {
        if (config('app.env') == 'testing') {
            return;
        }
        if (!Cache::has($moduleName . '.permissions.set')) {
            if (!Schema::hasTable('permissions') || !Schema::hasTable('roles')) {
                return;
            }

            $existingPermissionsQuery = Permission::query();
            $existingPermissions = $existingPermissionsQuery->whereIn('name', $permissions)->get()->keyBy('name');
            $newPermissions = [];

            foreach ($permissions as $permission) {
                if (!$existingPermissions->has($permission)) {
                    $newPermissions[] = ['name' => $permission, 'module' => $moduleName];
                }
            }

            if (!empty($newPermissions)) {
                Permission::insert($newPermissions);
            }
        }

        if ($cacheDuration == 'forever') {
            Cache::rememberForever($moduleName . '.permissions.set', fn() => true);
        } else {
            Cache::remember($moduleName . '.permissions.set', $cacheDuration, fn() => true);
        }
    }

    public function createGroups($moduleName, $groups, $permissions = [], $cacheDuration = 'forever'): void
    {
        if (config('app.env') == 'testing') {
            return;
        }
        if (!Cache::has($moduleName . '.groups.set')) {
            if (!Schema::hasTable('permissions') || !Schema::hasTable('roles')) {
                return;
            }

            if (is_string($groups)) {
                $groups = [$groups];
            }

            foreach ($groups as $group) {
                $role = Role::where('name', $group)->first();
                if (!$role) {
                    $role = Role::create(['name' => $group, 'module' => $moduleName]);
                }
                $role->syncPermissions($permissions);
            }
        }

        if ($cacheDuration == 'forever') {
            Cache::rememberForever($moduleName . '.groups.set', fn() => true);
        } else {
            Cache::remember($moduleName . '.groups.set', $cacheDuration, fn() => true);
        }
    }
}
