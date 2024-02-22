<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $table = 'settings';
    public $timestamps = true;

    protected $fillable = [
        'key',
        'value',
    ];
}
