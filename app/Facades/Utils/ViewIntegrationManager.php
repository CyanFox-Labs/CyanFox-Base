<?php

namespace App\Facades\Utils;

use App\Services\Utils\ViewIntegrationService;
use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * @method static add(string $name, ...$params)
 * @method static get(string $name = null)
 * @method static getAll(): array
 * @method static render(string $name, Closure $callback): ?string
 */
class ViewIntegrationManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ViewIntegrationService::class;
    }
}
