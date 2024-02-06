<?php

namespace App\Livewire\Account;

use App\Helpers\UnsplashHelper;
use App\Models\Session;
use Exception;
use Filament\Notifications\Notification;
use Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ForceActivateTwoFactor extends Component
{
    #[Url]
    public $redirect;
    public $unsplash;

    public $twoFactorCode;
    public $password;

    public function activateTwoFactor()
    {

        if (!Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => __('validation.current_password'),
            ]);
        }

        if(!auth()->user()->checkTwoFactorCode($this->twoFactorCode, false)) {
            throw ValidationException::withMessages([
                'twoFactorCode' => __('validation.custom.invalid_two_factor_code')
            ]);
        }

        try {
            auth()->user()->update([
                'two_factor_enabled' => true,
                'force_activate_two_factor' => false,
            ]);

            auth()->user()->generateRecoveryCodes();
        }catch (Exception $e) {
            Notification::make()
                ->title(__('messages.notifications.something_went_wrong'))
                ->danger()
                ->send();

            $this->dispatch('logger', ['type' => 'error', 'message' => $e->getMessage()]);
            return;
        }

        Session::logoutOtherDevices();

        Notification::make()
            ->title(__('pages/account/force_activate_two_factor.notifications.two_factor_enabled'))
            ->success()
            ->send();

        if ($this->redirect) {
            return redirect()->to($this->redirect);
        }

        $this->redirect(route('home'), navigate: true);
    }

    public function mount()
    {
        $unsplash = UnsplashHelper::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.account.force-activate-two-factor')->layout('components.layouts.guest', ['title' => __('navigation/titles.force_activate_two_factor')]);
    }
}
