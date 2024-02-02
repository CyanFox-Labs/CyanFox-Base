<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Validator;

class Password implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rules = [
            'min:' . setting('security_password_minimum_length'),
        ];

        $messages = ['min' => __('validation.size.string', ['attribute' => $attribute, 'size' => setting('security_password_minimum_length')])];

        if (setting('security_password_require_numbers')) {
            $rules[] = 'regex:/[0-9]/';
            $messages['regex'] = __('validation.password.numbers', ['attribute' => $attribute]);
        }

        if (setting('security_password_require_special_characters')) {
            $rules[] = 'regex:/[^a-zA-Z0-9]/';
            $messages['regex'] = __('validation.password.symbols', ['attribute' => $attribute]);
        }

        if (setting('security_password_require_uppercase')) {
            $rules[] = 'regex:/[A-Z]/';
            $messages['regex'] = __('validation.password.mixed', ['attribute' => $attribute]);
        }

        if (setting('security_password_require_lowercase')) {
            $rules[] = 'regex:/[a-z]/';
            $messages['regex'] = __('validation.password.mixed', ['attribute' => $attribute]);
        }

        $validator = Validator::make([$attribute => $value], [$attribute => $rules], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            foreach ($errors[$attribute] as $error){
                $fail($error);
            }
        }
    }
}
