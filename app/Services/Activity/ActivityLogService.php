<?php

namespace App\Services\Activity;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    private $logName;

    private $description;

    private $performedBy;

    private $subject;

    private $causer;

    private $ipAddress;

    public function logName(string $name): self
    {
        $this->logName = $name;

        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function performedBy(User $performedBy): self
    {
        $this->performedBy = $performedBy;

        return $this;
    }

    public function subject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function causer(string $causer): self
    {
        $this->causer = $causer;

        return $this;
    }

    public function ipAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function save(): void
    {
        $activityLog = new ActivityLog();
        $activityLog->log_name = $this->logName ?? 'system';
        $activityLog->description = $this->description;
        $activityLog->performed_by = $this->performedBy->id ?? Auth::user()->id;
        $activityLog->subject = $this->subject ?? null;
        $activityLog->causer = $this->causer ?? Auth::user()->username;
        $activityLog->ip_address = $this->ipAddress ?? request()->ip();
        $activityLog->save();
    }
}
