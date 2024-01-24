<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'theme',
        'language',
        'two_factor_enabled',
        'two_factor_secret',
        'force_change_password',
        'force_activate_two_factor',
        'password_reset_token',
        'password_reset_expiration',
        'github_id',
        'gitlab_id',
        'google_id',
        'disabled',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'remember_token',
        'password_reset_token',
        'password_reset_expiration',
    ];

    protected $casts = [
        'password' => 'hashed',
        'two_factor_secret' => 'encrypted',
        'password_reset_token' => 'encrypted',
    ];


    /* Utility Functions */
    public function getAvatarURL(): string
    {
        $filePath = 'profile-images/' . $this->id . '.png';
        if (Storage::disk('public')->exists($filePath)) {
            return asset('storage/' . $filePath) . '?v=' . md5_file(storage_path('app/public/' . $filePath));
        }

        return str_replace('{USER}', urlencode($this->username), setting('profile_default_avatar_url'));
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
            'cyanfox_dark'
        ];
        if (in_array($this->theme, $darkThemes)) {
            return 'dark';
        } else {
            return 'light';
        }

    }

    public function regenerateRememberToken(): void
    {
        $this->setRememberToken(Str::random(32));
        $this->save();
    }

    /* Two-Factor Auth */
    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function generateTwoFactorSecret(): void
    {
        $twoFactor = new Google2FA();
        $this->two_factor_secret = encrypt($twoFactor->generateSecretKey());
        $this->save();
    }

    public function generateRecoveryCodes(): void
    {
        UserRecoveryCode::where('user_id', $this->id)->delete();

        for ($i = 0; $i < 8; $i++) {
            UserRecoveryCode::create([
                'user_id' => $this->id,
                'code' => encrypt(Str::random(10)),
            ]);
        }
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function checkTwoFactorCode($key, $checkRecovery = true): bool
    {
        if ($key == null || $key == '') {
            return false;
        }

        if ($checkRecovery) {
            $recoveryCodes = UserRecoveryCode::where('user_id', $this->id)->get();

            foreach ($recoveryCodes as $recoveryCode) {
                if (decrypt($recoveryCode->code) == $key) {
                    $recoveryCode->delete();
                    return true;
                }
            }
        }

        $twoFactor = new Google2FA();
        $twoFactorSecret = decrypt($this->two_factor_secret);
        return $twoFactor->verifyKey($twoFactorSecret, $key);
    }

    public function getTwoFactorImage(): string
    {
        $twoFactor = new Google2FA();
        $QRCode = $twoFactor->getQRCodeUrl(config('app.name'), $this->email, decrypt($this->two_factor_secret));
        return base64_encode(QrCode::format('svg')->size(200)->generate($QRCode));
    }
}
