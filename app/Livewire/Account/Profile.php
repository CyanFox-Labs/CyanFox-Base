<?php

namespace App\Livewire\Account;

use App\Facades\ActivityLogManager;
use App\Facades\UserManager;
use App\Rules\Password;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Profile extends Component
{
    #[Url]
    public $tab = 'overview';

    public $themes = [];

    public $theme;

    public $language;

    public $user;

    public $firstName;

    public $lastName;

    public $email;

    public $username;

    public $currentPassword;

    public $newPassword;

    public $passwordConfirmation;

    public function updateLanguageAndTheme(): void
    {
        $this->validate([
            'language' => ['required', 'string'],
            'theme' => ['required', 'string'],
        ]);

        try {
            $this->user->update([
                'language' => $this->language,
                'theme' => $this->theme,
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('account')
            ->description('account:profile.update')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('account/profile.language_and_theme.notifications.language_and_theme_updated'))
            ->success()
            ->send();

        $this->redirect(route('account.profile'));
    }

    public function updateProfileInformations(): void
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,'.auth()->user()->getAuthIdentifier().',id',
            'email' => 'required|max:255|email|unique:users,email,'.auth()->user()->getAuthIdentifier().',id',
        ]);

        try {
            $this->user->update([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'email' => $this->email,
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        ActivityLogManager::logName('account')
            ->description('account:profile.update')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('account/profile.overview.notifications.profile_informations_updated'))
            ->success()
            ->send();

        $this->redirect(route('account.profile'), navigate: true);
    }

    public function updatePassword(): void
    {

        $this->validate([
            'currentPassword' => 'required|max:255',
            'newPassword' => ['required', 'max:255', 'same:passwordConfirmation', new Password],
            'passwordConfirmation' => 'required',
        ]);

        if (!Hash::check($this->currentPassword, $this->user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => __('validation.current_password'),
            ]);
        }

        try {
            $this->user->update([
                'password' => Hash::make($this->newPassword),
            ]);
        } catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);

            return;
        }

        UserManager::getUser($this->user)->getSessionManager()->revokeOtherSessions();

        ActivityLogManager::logName('account')
            ->description('account:profile.update')
            ->causer($this->user->username)
            ->subject($this->user->username)
            ->performedBy($this->user)
            ->save();

        Notification::make()
            ->title(__('account/profile.overview.notifications.password_updated'))
            ->success()
            ->send();

        $this->redirect(route('account.profile'), navigate: true);
    }

    public function mount(): void
    {
        if (!in_array($this->tab, ['overview', 'sessions', 'apiKeys', 'activity'])) {
            $this->tab = 'overview';
        }

        /* Language and Theme */
        $themeIds = ['dark', 'light', 'cupcake', 'bumblebee', 'emerald', 'corporate', 'synthwave', 'retro',
            'valentine', 'halloween', 'garden', 'forest', 'lofi', 'pastel', 'fantasy', 'wireframe', 'black',
            'luxury', 'dracula', 'cmyk', 'autumn', 'business', 'acid', 'lemonade', 'night', 'coffee', 'winter',
            'dim', 'nord', 'sunset', 'catppuccin_latte', 'catppuccin_frappee', 'catppuccin_macchiato',
            'catppuccin_mocha', 'cyanfox_dark', 'cyanfox_light',
        ];

        foreach ($themeIds as $themeId) {
            $this->themes[] = ['id' => $themeId, 'name' => __('account/profile.language_and_theme.themes.'.$themeId)];
        }

        $this->user = Auth::user();

        $this->theme = $this->user->theme;
        $this->language = $this->user->language;

        $this->firstName = $this->user->first_name;
        $this->lastName = $this->user->last_name;
        $this->email = $this->user->email;
        $this->username = $this->user->username;
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.account.profile')
            ->layout('components.layouts.app', ['title' => __('account/profile.tab_title')]);
    }
}
