<?php

use App\Facades\Utils\SettingsManager;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    if (!setting('settings.telemetry.url') || !setting('settings.telemetry.enabled')) {
        return;
    }
    if (!setting('settings.telemetry.instance')) {
        SettingsManager::updateSetting('settings.telemetry.instance', Str::random(32), true);
    }
    Http::post(setting('settings.telemetry.url'), [
        'instance' => setting('settings.telemetry.instance'),
        'modules' => \Nwidart\Modules\Facades\Module::count(),
        'os' => PHP_OS,
        'php' => PHP_VERSION,
        'laravel' => app()->version(),
        'db' => DB::getDriverName(),
        'timezone' => setting('settings.timezone'),
        'lang' => setting('settings.lang'),
        'template_version' => version()->getCurrentTemplateVersion(),
        'project_version' => version()->getCurrentProjectVersion(),
    ]);
})->daily();
