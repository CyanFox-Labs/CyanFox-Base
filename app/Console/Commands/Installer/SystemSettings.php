<?php

namespace App\Console\Commands\Installer;

use App\Facades\SettingsManager;
use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class SystemSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'c:installer:system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the system settings for the application.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $appName = text('Application Name', setting('app_name'), setting('app_name'), required: true);
        $appUrl = text('Application URL', setting('app_url'), setting('app_url'), required: true);
        $appLanguage = select('Application Language', ['en' => 'English', 'de' => 'German'], required: true);
        $appTimezone = suggest('Application Timezone', timezone_identifiers_list(), required: true);
        $unsplashAPIKey = text('Unsplash API Key', setting('unsplash_api_key', true), setting('unsplash_api_key', true));
        $unsplashUTM = text('Unsplash UTM', setting('unsplash_utm'), setting('unsplash_utm'));
        $projectVersionUrl = text('Project Version URL', setting('project_version_url'), setting('project_version_url'));
        $templateVersionUrl = text('Template Version URL', setting('template_version_url'), setting('template_version_url'));
        $iconUrl = text('Icon URL', setting('icon_url'), setting('icon_url'));

        $settings = [
            'app_name' => $appName,
            'app_url' => $appUrl,
            'app_lang' => $appLanguage,
            'app_timezone' => $appTimezone,
            'unsplash_utm' => $unsplashUTM,
            'unsplash_api_key' => $unsplashAPIKey ? encrypt($unsplashAPIKey) : null,
            'project_version_url' => $projectVersionUrl,
            'template_version_url' => $templateVersionUrl,
            'icon_url' => $iconUrl,
            'app_installed' => 1,
        ];

        SettingsManager::updateSettings($settings);

        $this->info('System settings saved.');

        $continue = confirm('Would you like to create a new user?', true);
        if ($continue) {
            $this->call('c:admin:users.create');
        }
    }
}
