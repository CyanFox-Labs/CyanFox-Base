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
        'disabled',
        'password_reset_token',
        'password_reset_expiration',
        'custom_avatar_url',
        'discord_id',
        'github_id',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'remember_token',
        'password_reset_token',
        'password_reset_expiration',
    ];
}
