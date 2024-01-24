<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{

    public $table = 'activity_log';
    public $timestamps = true;

    protected $fillable = [
        'log_name',
        'log_message',
        'performed_by',
        'subject',
        'causer',
        'ip_address',
        'original_values',
        'new_values',
    ];


    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
