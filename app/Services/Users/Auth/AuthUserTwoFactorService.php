<?php

namespace App\Services\Users\Auth;

use App\Models\UserRecoveryCode;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthUserTwoFactorService
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function isTwoFactorEnabled(): bool
    {
        return $this->user->two_factor_enabled == 1;
    }

    public function generateTwoFactorSecret(): void
    {
        $twoFactor = new Google2FA;
        $this->user->two_factor_secret = encrypt($twoFactor->generateSecretKey());
        $this->user->save();
    }

    public function generateRecoveryCodes(): array
    {
        UserRecoveryCode::where('user_id', $this->user->id)->delete();

        $recoverCodes = [];

        for ($i = 0; $i < 8; $i++) {
            $recoveryCode = Str::password(10);
            UserRecoveryCode::create([
                'user_id' => $this->user->id,
                'code' => encrypt($recoveryCode),
            ]);
            $recoverCodes[] = $recoveryCode;
        }

        return $recoverCodes;
    }

    public function checkTwoFactorCode(string $key, bool $checkRecovery = true): bool
    {
        if ($key == null || $key == '') {
            return false;
        }

        if ($checkRecovery) {
            $recoveryCodes = UserRecoveryCode::where('user_id', $this->user->id)->get();

            foreach ($recoveryCodes as $recoveryCode) {
                if (decrypt($recoveryCode->code) == $key) {
                    $recoveryCode->delete();

                    return true;
                }
            }
        }

        $twoFactor = new Google2FA;
        $twoFactorSecret = decrypt($this->user->two_factor_secret);

        return $twoFactor->verifyKey($twoFactorSecret, $key);
    }

    public function getTwoFactorImage(): string
    {
        $twoFactor = new Google2FA;
        $QRCode = $twoFactor->getQRCodeUrl(config('app.name'), $this->user->email, decrypt($this->user->two_factor_secret));

        return base64_encode(QrCode::format('svg')->size(200)->generate($QRCode));
    }
}
