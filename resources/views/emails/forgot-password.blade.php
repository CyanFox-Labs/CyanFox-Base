{!! __('emails.forgot_password.content', ['username' => $username,
            'first_name' => $first_name, 'last_name' => $last_name,
            'reset_link' => route('forgot-password', [$password_reset_token])]) !!}
