<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class AuthSettings extends Component
{

    public $tab;
    public $options;

    public $enableAuth;
    public $enableCaptcha;
    public $enableForgotPassword;
    public $enableRegistration;
    public $enableOAuth;
    public $enableLocalLogin;


    public $enableGoogleOAuth;
    public $googleClientId;
    public $googleClientSecret;
    public $googleRedirectUrl;

    public $enableGithubOAuth;
    public $githubClientId;
    public $githubClientSecret;
    public $githubRedirectUrl;

    public $enableGitlabOAuth;
    public $gitlabClientId;
    public $gitlabClientSecret;
    public $gitlabRedirectUrl;

    public function mount()
    {
        $this->options = [
            ['id' => '1', 'name' => __('messages.yes')],
            ['id' => '0', 'name' => __('messages.no')]
        ];


        if (!in_array($this->tab, ['google', 'github', 'gitlab'])) {
            $this->tab = 'google';
        }

        $this->enableAuth = setting('auth_enable');
        $this->enableCaptcha = setting('auth_enable_captcha');
        $this->enableForgotPassword = setting('auth_enable_forgot_password');
        $this->enableRegistration = setting('auth_enable_register');
        $this->enableOAuth = setting('auth_enable_oauth');
        $this->enableLocalLogin = setting('auth_enable_local_login');

        $this->enableGoogleOAuth = setting('oauth_enable_google');
        $this->googleClientId = setting('oauth_google_client_id');
        $this->googleClientSecret = decrypt(setting('oauth_google_client_secret'));
        $this->googleRedirectUrl = setting('oauth_google_redirect');

        $this->enableGithubOAuth = setting('oauth_enable_github');
        $this->githubClientId = setting('oauth_github_client_id');
        $this->githubClientSecret = decrypt(setting('oauth_github_client_secret'));
        $this->githubRedirectUrl = setting('oauth_github_redirect');

        $this->enableGitlabOAuth = setting('oauth_enable_gitlab');
        $this->gitlabClientId = setting('oauth_gitlab_client_id');
        $this->gitlabClientSecret = decrypt(setting('oauth_gitlab_client_secret'));
        $this->gitlabRedirectUrl = setting('oauth_gitlab_redirect');
    }

    public function updateAuthSettings()
    {
        $this->validate([
            'enableAuth' => 'nullable|boolean',
            'enableCaptcha' => 'nullable|boolean',
            'enableForgotPassword' => 'nullable|boolean',
            'enableRegistration' => 'nullable|boolean',
            'enableOAuth' => 'nullable|boolean',
            'enableLocalLogin' => 'nullable|boolean',
            'enableGoogleOAuth' => 'nullable|boolean',
            'googleClientId' => 'nullable|string',
            'googleClientSecret' => 'nullable|string',
            'googleRedirectUrl' => 'nullable|string|url',
            'enableGithubOAuth' => 'nullable|boolean',
            'githubClientId' => 'nullable|string',
            'githubClientSecret' => 'nullable|string',
            'githubRedirectUrl' => 'nullable|string|url',
            'enableGitlabOAuth' => 'nullable|boolean',
            'gitlabClientId' => 'nullable|string',
            'gitlabClientSecret' => 'nullable|string',
            'gitlabRedirectUrl' => 'nullable|string|url',
        ]);

        $settings = [
            'auth_enable' => $this->enableAuth,
            'auth_enable_captcha' => $this->enableCaptcha,
            'auth_enable_forgot_password' => $this->enableForgotPassword,
            'auth_enable_register' => $this->enableRegistration,
            'auth_enable_oauth' => $this->enableOAuth,
            'auth_enable_local_login' => $this->enableLocalLogin,
            'oauth_enable_google' => $this->enableGoogleOAuth,
            'oauth_google_client_id' => $this->googleClientId,
            'oauth_google_client_secret' => $this->googleClientSecret ? encrypt($this->googleClientSecret) : null,
            'oauth_google_redirect' => $this->googleRedirectUrl,
            'oauth_enable_github' => $this->enableGithubOAuth,
            'oauth_github_client_id' => $this->githubClientId,
            'oauth_github_client_secret' => $this->githubClientSecret ? encrypt($this->githubClientSecret) : null,
            'oauth_github_redirect' => $this->githubRedirectUrl,
            'oauth_enable_gitlab' => $this->enableGitlabOAuth,
            'oauth_gitlab_client_id' => $this->gitlabClientId,
            'oauth_gitlab_client_secret' => $this->gitlabClientSecret ? encrypt($this->gitlabClientSecret) : null,
            'oauth_gitlab_redirect' => $this->gitlabRedirectUrl,
        ];

        foreach ($settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        Notification::make()
            ->success()
            ->title(__('pages/admin/settings/settings.notifications.settings_updated'))
            ->send();

        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.settings.auth-settings');
    }
}
