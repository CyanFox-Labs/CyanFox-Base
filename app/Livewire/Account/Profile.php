<?php

namespace App\Livewire\Account;

use App\Models\Session;
use Filament\Notifications\Notification;
use Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;

class Profile extends Component
{

    #[Url]
    public $tab = 'overview';

    public $themes = [];
    public $theme;
    public $language;


    public $firstName;
    public $lastName;
    public $email;
    public $username;

    public $currentPassword;
    public $newPassword;
    public $passwordConfirmation;

    public function mount()
    {
        if (!in_array($this->tab, ['overview', 'sessions', 'apiKeys', 'activity'])) {
            $this->tab = 'overview';
        }


        /* Language and Theme */
        $themeIds = ['dark', 'light', 'cupcake', 'bumblebee', 'emerald', 'corporate', 'synthwave', 'retro',
            'valentine', 'halloween', 'garden', 'forest', 'lofi', 'pastel', 'fantasy', 'wireframe', 'black',
            'luxury', 'dracula', 'cmyk', 'autumn', 'business', 'acid', 'lemonade', 'night', 'coffee', 'winter',
            'dim', 'nord', 'sunset', 'catppuccin_latte', 'catppuccin_frappee', 'catppuccin_macchiato',
            'catppuccin_mocha', 'cyanfox_dark', 'cyanfox_light'
        ];

        foreach ($themeIds as $themeId) {
            $this->themes[] = ['id' => $themeId, 'name' => __('pages/account/profile.language_and_theme.themes.' . $themeId)];
        }

        $this->theme = auth()->user()->theme;
        $this->language = auth()->user()->language;


        /* Account Informations */
        $this->firstName = auth()->user()->first_name;
        $this->lastName = auth()->user()->last_name;
        $this->email = auth()->user()->email;
        $this->username = auth()->user()->username;
    }

    public function updateLanguageAndTheme()
    {
        $this->validate([
            'language' => ['required', 'string'],
            'theme' => ['required', 'string'],
        ]);

        auth()->user()->update([
            'language' => $this->language,
            'theme' => $this->theme,
        ]);

        Notification::make()
            ->title(__('pages/account/profile.notifications.language_and_theme_updated'))
            ->success()
            ->send();

        return redirect()->route('account.profile');
    }


    public function updateProfileInformations()
    {
        $this->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . auth()->user()->getAuthIdentifier() . ',id',
            'email' => 'required|max:255|email|unique:users,email,' . auth()->user()->getAuthIdentifier() . ',id'
        ]);

        auth()->user()->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'email' => $this->email,
        ]);

        Notification::make()
            ->title(__('pages/account/profile.notifications.profile_informations_updated'))
            ->success()
            ->send();

        return redirect()->route('account.profile');
    }

    public function updatePassword()
    {

        $this->validate([
            'currentPassword' => 'required|max:255',
            'newPassword' => 'required|max:255|same:passwordConfirmation',
            'passwordConfirmation' => 'required',
        ]);

        if (!Hash::check($this->currentPassword, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => __('validation.current_password'),
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($this->newPassword),
        ]);


        Session::logoutOtherDevices();

        Notification::make()
            ->title(__('pages/account/profile.notifications.password_updated'))
            ->success()
            ->send();

        return redirect()->route('account.profile');
    }

    public function render()
    {
        return view('livewire.account.profile')
            ->layout('components.layouts.app', ['title' => __('navigation/titles.profile')]);
    }
}
