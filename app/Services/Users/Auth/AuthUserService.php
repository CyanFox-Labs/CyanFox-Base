<?php

namespace App\Services\Users\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthUserService
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getGroups(): array
    {
        return $this->user->groups->pluck('name')->toArray();
    }

    public function getPermissions(): array
    {
        return $this->user->getAllPermissions()->pluck('name')->toArray();
    }

    public function regenerateRememberToken(): string
    {
        $rememberToken = Str::password();

        $this->user->setRememberToken($rememberToken);
        $this->user->save();

        return $rememberToken;
    }

    public function getAvatarURL(): string
    {
        if ($this->user->custom_avatar_url) {
            return $this->user->custom_avatar_url;
        }

        $filePath = 'avatars/'.$this->user->id.'.png';
        if (Storage::disk('public')->exists($filePath)) {
            return asset('storage/'.$filePath).'?v='.md5_file(storage_path('app/public/'.$filePath));
        }

        return str_replace('{username}', urlencode($this->user->username), setting('profile_default_avatar_url'));
    }

    public function getColorScheme(): string
    {
        $darkThemes = [
            'dark',
            'synthwave',
            'halloween',
            'forest',
            'black',
            'luxury',
            'business',
            'coffee',
            'night',
            'dracula',
            'dim',
            'sunset',
            'catppuccin_frappee',
            'catppuccin_macchiato',
            'catppuccin_mocha',
            'cyanfox_dark',
        ];
        if (in_array($this->user->theme, $darkThemes)) {
            return 'dark';
        } else {
            return 'light';
        }

    }

    public function getSessionManager(): AuthUserSessionService
    {
        return new AuthUserSessionService($this->user);
    }

    public function getAPIKeyManager(): AuthUserAPIKeyService
    {
        return new AuthUserAPIKeyService($this->user);
    }

    public function getTwoFactorManager(): AuthUserTwoFactorService
    {
        return new AuthUserTwoFactorService($this->user);
    }
}
