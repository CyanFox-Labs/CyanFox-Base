<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class HCaptchaValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $captchaResp = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'response' => $value,
            'secret' => env('HCAPTCHA_SECRET')
        ])->object();

        if (!$captchaResp->success) {
            $fail(__('messages.invalid_captcha'));
        }

    }

}

