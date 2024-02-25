<?php

namespace App\Services\Groups;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class GroupService
{

    public function getAllGroups(): Collection
    {
        return Role::all();
    }

    public function findGroup(int $groupId): ?Role
    {
        return Role::findById($groupId);
    }

    public function findGroupByName(string $groupName): ?Role
    {
        return Role::findByName($groupName);
    }
}
