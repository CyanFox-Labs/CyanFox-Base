<?php

namespace App\Facades;

use App\Services\Groups\GroupService;
use Illuminate\Support\Facades\Facade;
use Spatie\Permission\Models\Role;

/**
 * @method static Role findGroup(int $groupId)
 * @method static Role findGroupByName(string $groupName)
 * @method static array getPermissionsFromGroup(Role $group)
 */
class GroupManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GroupService::class;
    }
}
