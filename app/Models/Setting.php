<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public $table = 'settings';
    public $timestamps = true;

    protected $fillable = [
        'identifier',
        'key',
        'value',
    ];
}
