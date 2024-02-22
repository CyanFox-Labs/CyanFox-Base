<?php

namespace App\Facades;

use App\Services\Activity\ActivityLogService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ActivityLogService logName(string $name)
 * @method static ActivityLogService description(string $description)
 * @method static ActivityLogService performedBy(int $performedBy)
 * @method static ActivityLogService subject(string $subject)
 * @method static ActivityLogService causer(string $causer)
 * @method static ActivityLogService ipAddress(string $ipAddress)
 * @method static void save()
 */
class ActivityLogManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ActivityLogService::class;
    }

}
