<?php

namespace App\Services\Groups;

use Spatie\Permission\Models\Role;

class GroupService
{
    public function findGroup(int $groupId): ?Role
    {
        return Role::findById($groupId);
    }

    public function findGroupByName(string $groupName): ?Role
    {
        return Role::findByName($groupName);
    }

    public function getPermissionsFromGroup(Role $group): array
    {
        return $group->permissions->pluck('name')->toArray();
    }
}
