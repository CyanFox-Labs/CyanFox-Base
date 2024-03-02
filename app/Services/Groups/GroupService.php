<?php

namespace App\Services\Groups;

use Spatie\Permission\Models\Role;

class GroupService
{
    /**
     * Finds a group by its ID.
     *
     * @param int $groupId The ID of the group to find.
     * @return Role|null The group with the specified ID if found, null otherwise.
     */
    public function findGroup(int $groupId): ?Role
    {
        return Role::findById($groupId);
    }

    /**
     * Find a group by its name.
     *
     * @param string $groupName The name of the group to find.
     * @return Role|null The group with the given name, or null if not found.
     */
    public function findGroupByName(string $groupName): ?Role
    {
        return Role::findByName($groupName);
    }

    /**
     * Get the permissions from a given group.
     *
     * @param Role $group The group from which to retrieve the permissions.
     *
     * @return array An array of permission names.
     */
    public function getPermissionsFromGroup(Role $group): array
    {
        return $group->permissions->pluck('name')->toArray();
    }
}
