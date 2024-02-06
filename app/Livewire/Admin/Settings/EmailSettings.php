<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Storage;
use Str;

class EmailSettings extends Component implements HasForms
{
    use InteractsWithForms;

    public $tab;

    public $welcomeEmailTitle;
    public $welcomeEmailSubject;
    public ?array $welcomeEmailData = [];

    public $enableLoginEmail = true;
    public $loginEmailTitle;
    public $loginEmailSubject;
    public ?array $loginEmailData = [];

    public $forgotPasswordEmailTitle;
    public $forgotPasswordEmailSubject;
    public ?array $forgotPasswordEmailData = [];

    protected function getForms(): array
    {
        return [
            'welcomeEmailContent',
            'loginEmailContent',
            'forgotPasswordEmailContent',
        ];
    }

    public function welcomeEmailContent(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('welcomeEmailContent')
                    ->name(__('pages/admin/settings/email_settings.welcome.content'))
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->required(),
            ])
            ->statePath('welcomeEmailData');
    }

    public function loginEmailContent(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('loginEmailContent')
                    ->name(__('pages/admin/settings/email_settings.login.content'))
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->required(),
            ])
            ->statePath('loginEmailData');
    }

    public function forgotPasswordEmailContent(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('forgotPasswordEmailContent')
                    ->name(__('pages/admin/settings/email_settings.forgot_password.content'))
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->required(),
            ])
            ->statePath('forgotPasswordEmailData');
    }

    public function updateEmailSettings()
    {
        $this->validate([
            'welcomeEmailTitle' => 'required|string',
            'welcomeEmailSubject' => 'required|string',
            'enableLoginEmail' => 'required|boolean',
            'loginEmailTitle' => 'required|string',
            'loginEmailSubject' => 'required|string',
            'forgotPasswordEmailTitle' => 'required|string',
            'forgotPasswordEmailSubject' => 'required|string',
        ]);

        $settings = [
            'emails_welcome_title' => $this->welcomeEmailTitle,
            'emails_welcome_subject' => $this->welcomeEmailSubject,
            'emails_welcome_content' => $this->welcomeEmailData['welcomeEmailContent'],
            'emails_login_enabled' => $this->enableLoginEmail,
            'emails_login_title' => $this->loginEmailTitle,
            'emails_login_subject' => $this->loginEmailSubject,
            'emails_login_content' => $this->loginEmailData['loginEmailContent'],
            'emails_forgot_password_title' => $this->forgotPasswordEmailTitle,
            'emails_forgot_password_subject' => $this->forgotPasswordEmailSubject,
            'emails_forgot_password_content' => $this->forgotPasswordEmailData['forgotPasswordEmailContent'],
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


    public function mount()
    {
        if (!in_array($this->tab, ['welcome', 'login', 'forgotPassword'])) {
            $this->tab = 'welcome';
        }

        /* Welcome email */
        $this->welcomeEmailTitle = setting('emails_welcome_title');
        $this->welcomeEmailSubject = setting('emails_welcome_subject');
        $this->welcomeEmailContent->fill(['welcomeEmailContent' => setting('emails_welcome_content')]);

        /* Login email */
        $this->enableLoginEmail = setting('emails_login_enabled');
        $this->loginEmailTitle = setting('emails_login_title');
        $this->loginEmailSubject = setting('emails_login_subject');
        $this->loginEmailContent->fill(['loginEmailContent' => setting('emails_login_content')]);

        /* Forgot Password email */
        $this->forgotPasswordEmailTitle = setting('emails_forgot_password_title');
        $this->forgotPasswordEmailSubject = setting('emails_forgot_password_subject');
        $this->forgotPasswordEmailContent->fill(['forgotPasswordEmailContent' => setting('emails_forgot_password_content')]);
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.settings.email-settings');
    }
}
