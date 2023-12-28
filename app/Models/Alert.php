<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{

    protected $table = 'alerts';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'message',
        'type',
        'icon',
    ];
}
