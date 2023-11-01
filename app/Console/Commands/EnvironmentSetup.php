<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class EnvironmentSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cf:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set basic environment variables / settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $default_lang = select(
            'What is the default language for the application?',
            ['en', 'de']
        );

        $unsplash_api_key = password(
            'What is the Unsplash API key? (https://unsplash.com/developers) | Leave blank to leave empty'
        );

        $enable_registration = confirm(
            'Do you want to enable registration?'
        );

        $enable_forgot_password = confirm(
            'Do you want to enable forgot password? (Requires mail setup)'
        );

        $enable_hcaptcha = confirm(
            'Do you want to enable HCaptcha?'
        );

        $hcaptcha_site_key = '';
        $hcaptcha_secret_key = '';

        if ($enable_hcaptcha) {
            $hcaptcha_site_key = text(
                'What is the HCaptcha site key?'
            );

            $hcaptcha_secret_key = password(
                'What is the HCaptcha secret key?'
            );
        }

        $change_urls = confirm(
            'Do you want to change the default Version URLs?', false
        );

        $template_url = '';
        $project_url = '';

        if ($change_urls) {
            $template_url = text(
                'What is the Template Version URL?'
            );

            $project_url = text(
                'What is the Project Version URL?'
            );
        }

        if ($enable_registration == 1) {
            $enable_registration = 'true';
        } else {
            $enable_registration = 'false';
        }

        if ($enable_forgot_password == 1) {
            $enable_forgot_password = 'true';
        } else {
            $enable_forgot_password = 'false';
        }

        if ($enable_hcaptcha == 1) {
            $enable_hcaptcha = 'true';
        } else {
            $enable_hcaptcha = 'false';
        }


        $this->info('Setting up environment variables...');

        DotenvEditor::setKey('APP_LANG', $default_lang);
        DotenvEditor::setKey('UNSPLASH_API_KEY', $unsplash_api_key);
        DotenvEditor::setKey('ENABLE_REGISTRATION', $enable_registration);
        DotenvEditor::setKey('ENABLE_FORGOT_PASSWORD', $enable_forgot_password);
        DotenvEditor::setKey('ENABLE_HCAPTCHA', $enable_hcaptcha);
        DotenvEditor::setKey('HCAPTCHA_SITE_KEY', $hcaptcha_site_key);
        DotenvEditor::setKey('HCAPTCHA_SECRET', $hcaptcha_secret_key);
        DotenvEditor::setKey('TEMPLATE_VERSION_URL', $template_url);
        DotenvEditor::setKey('PROJECT_VERSION_URL', $project_url);
        DotenvEditor::save();

        $this->info('Environment variables set!');

    }
}
