<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRecoveryCode extends Model
{

    public const UPDATED_AT = null;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'code',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'code' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
