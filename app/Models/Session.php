<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $table = 'sessions';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    public static function logoutOtherDevices()
    {
        self::where('user_id', auth()->user()->id)
            ->whereNotIn('id', [\Illuminate\Support\Facades\Session::getId()])
            ->delete();
    }
}
