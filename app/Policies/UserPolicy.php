<?php

namespace App\Policies;

class UserPolicy
{
    public function canDeleteAccount(): bool
    {
        if (setting('profile_enable_delete_account')) {
            return true;
        }

        return false;
    }

    public function canUpdateAvatar(): bool
    {
        if (setting('profile_enable_change_avatar')) {
            return true;
        }

        return false;
    }
}
