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
    private $originalValues;
    private $newValues;
    private $performedBy;

    public function setLogMessage($logMessage): ActivityLogHelper
    {
        $this->logMessage = $logMessage;
        return $this;
    }

    public function setSubject($subject): ActivityLogHelper
    {
        $this->subject = $subject;
        return $this;
    }

    public function setCausedBy($causer): ActivityLogHelper
    {
        $this->causer = $causer;
        return $this;
    }

    public function setIpAddress($ipAddress): ActivityLogHelper
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function setOriginalValues($originalValues): ActivityLogHelper
    {
        $this->originalValues = $originalValues;
        return $this;
    }

    public function setNewValues($newValues): ActivityLogHelper
    {
        $this->newValues = $newValues;
        return $this;
    }

    public function setLogName($logName): ActivityLogHelper
    {
        $this->logName = $logName;
        return $this;
    }

    public function setPerformedBy($userId): ActivityLogHelper
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
        $activityLog->ip_address = $this->ipAddress;
        $activityLog->original_values = json_encode($this->originalValues);
        $activityLog->new_values = json_encode($this->newValues);
        $activityLog->performed_by = $this->performedBy;
        $activityLog->save();
    }

}
