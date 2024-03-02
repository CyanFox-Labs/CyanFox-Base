<?php

namespace App\Services\Users\Auth;

use App\Models\UserRecoveryCode;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthUserTwoFactorService
{
    /**
     * Holds the user information.
     *
     * @var array
     */
    private $user;

    /**
     * Class constructor.
     *
     * Initializes the object and assigns the provided user.
     *
     * @param mixed $user The user to be assigned to the object.
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Determines if two-factor authentication is enabled for the user.
     *
     * @return bool Returns true if two-factor authentication is enabled, otherwise returns false.
     */
    public function isTwoFactorEnabled(): bool
    {
        return $this->user->two_factor_enabled == 1;
    }

    /**
     * Generates a two-factor authentication secret for the current user.
     *
     * This method generates a secret key using the Google2FA library and assigns it to the current user's
     * two-factor secret property. The secret key is then encrypted and saved to the user model.
     *
     * @return void
     */
    public function generateTwoFactorSecret(): void
    {
        $twoFactor = new Google2FA;
        $this->user->two_factor_secret = encrypt($twoFactor->generateSecretKey());
        $this->user->save();
    }

    /**
     * Generate recovery codes for the user.
     *
     * Deletes any existing recovery codes for the user and generates new ones.
     *
     * @return array Returns an array of 8 recovery codes.
     */
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

    /**
     * Check if the provided two-factor code is valid for the user.
     *
     * @param string $key The two-factor code to check.
     * @param bool $checkRecovery (optional) Specifies whether to check for recovery codes as well. Defaults to true.
     *
     * @return bool Returns true if the provided code is valid, false otherwise.
     */
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

    /**
     * Retrieves the two-factor authentication QR code image.
     *
     * @return string The base64-encoded SVG image of the QR code.
     */
    public function getTwoFactorImage(): string
    {
        $twoFactor = new Google2FA;
        $QRCode = $twoFactor->getQRCodeUrl(config('app.name'), $this->user->email, decrypt($this->user->two_factor_secret));

        return base64_encode(QrCode::format('svg')->size(200)->generate($QRCode));
    }
}
