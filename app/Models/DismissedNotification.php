<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DismissedNotification extends Model
{
    protected $table = 'dismissed_notifications';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'notification_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
