<?php

namespace App\Facades\Utils;

use App\Services\Utils\ViewIntegrationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void add(string $name, mixed ...$params)
 * @method static void addView(string $name, string $view)
 * @method static Collection get(?string $name = null)
 * @method static array getAll()
 * @method static ?string render(string $name, \Closure $callback)
 */
class ViewIntegrationManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ViewIntegrationService::class;
    }
}
