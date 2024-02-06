<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotlightValue extends Model
{
    public $table = 'spotlight_values';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'name_translation_key',
        'description_translation_key',
        'link',
        'icon',
        'admin',
    ];
}
