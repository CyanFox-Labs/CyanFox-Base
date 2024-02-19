<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogHelper
{
    private $logName;


    private $logMessage;
    private $subject;
    private $causer;
    private $ipAddress;
    private $performedBy;

    public function logMessage($logMessage): ActivityLogHelper
    {
        $this->logMessage = $logMessage;
        return $this;
    }

    public function subject($subject): ActivityLogHelper
    {
        $this->subject = $subject;
        return $this;
    }

    public function causer($causer): ActivityLogHelper
    {
        $this->causer = $causer;
        return $this;
    }

    public function ipAddress($ipAddress): ActivityLogHelper
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function logName($logName): ActivityLogHelper
    {
        $this->logName = $logName;
        return $this;
    }

    public function performedBy($userId): ActivityLogHelper
    {
        $this->performedBy = $userId;
        return $this;
    }

    public function save()
    {
        $activityLog = new ActivityLog();
        $activityLog->log_name = $this->logName;
        $activityLog->log_message = $this->logMessage;
        $activityLog->subject = $this->subject;
        $activityLog->causer = $this->causer;
        $activityLog->ip_address = $this->ipAddress ?? request()->ip();
        $activityLog->performed_by = $this->performedBy;
        $activityLog->save();
    }

}
