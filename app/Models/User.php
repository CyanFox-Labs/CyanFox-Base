<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'username',
        'email',
        'password',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $hidden = [
        'password',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'password_reset_token',
        'password_reset_expiration',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getProfileImageURL(): string
    {
        $filePath = 'profile-images/' . $this->id . '.png';
        if (Storage::disk('public')->exists($filePath)) {
            return asset('storage/' . $filePath) . '?v=' . md5_file(storage_path('app/public/' . $filePath));
        }

        return str_replace('{USER}', $this->email, env('DEFAULT_AVATAR_URL'));
    }

    public function getColorScheme(): string
    {
        if (    auth()->user()->theme == 'dark' ||
            auth()->user()->theme == 'synthwave' ||
            auth()->user()->theme == 'halloween' ||
            auth()->user()->theme == 'forest' ||
            auth()->user()->theme == 'black' ||
            auth()->user()->theme == 'luxury' ||
            auth()->user()->theme == 'business' ||
            auth()->user()->theme == 'coffee' ||
            auth()->user()->theme == 'night' ||
            auth()->user()->theme == 'dracula' ||
            auth()->user()->theme == 'dim' ||
            auth()->user()->theme == 'sunset' ||
            auth()->user()->theme == 'catppuccin_frappee' ||
            auth()->user()->theme == 'catppuccin_macchiato' ||
            auth()->user()->theme == 'catppuccin_mocha') {
            return 'dark';
        }else{
            return 'light';
        }

    }
}
