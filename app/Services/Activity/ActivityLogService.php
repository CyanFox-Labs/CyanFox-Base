<?php

namespace App\Services\Activity;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * The name of the log file.
     *
     * @var string
     */
    private $logName;

    /**
     * @var string $description The description of the code
     */
    private $description;

    /**
     * Represents the user who performed the action.
     *
     * @var string
     */
    private $performedBy;

    /**
     * The subject of the code.
     *
     * This variable represents the subject of the code.
     */
    private $subject;

    /**
     * Represents the object responsible for causing an action or event.
     *
     * @var object|null $causer The object responsible for causing the action.
     */
    private $causer;

    /**
     * @var string $ipAddress The IP address of the user.
     */
    private $ipAddress;

    /**
     * Sets the log name.
     *
     * @param string $name The name to set for the log.
     * @return $this Returns the instance of the class itself.
     */
    public function logName(string $name): self
    {
        $this->logName = $name;

        return $this;
    }

    /**
     * Set the description of the object.
     *
     * @param string $description The description to be set.
     * @return self Returns the instance of the object after setting the description.
     */
    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the user who performed the action.
     *
     * @param User $performedBy The user who performed the action.
     * @return $this
     */
    public function performedBy(User $performedBy): self
    {
        $this->performedBy = $performedBy;

        return $this;
    }

    /**
     * Set the subject of the object.
     *
     * @param string $subject The new subject to set.
     * @return self
     */
    public function subject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Sets the causer of the action.
     *
     * @param string $causer The causer of the action.
     *
     * @return self The current instance of the class.
     */
    public function causer(string $causer): self
    {
        $this->causer = $causer;

        return $this;
    }

    /**
     * Sets the IP address.
     *
     * @param string $ipAddress The IP address to set.
     * @return self Returns the instance of the class for method chaining.
     */
    public function ipAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Saves the activity log.
     *
     * Creates a new instance of ActivityLog and sets its properties based on the current object's properties.
     * If the log name is not set, it defaults to 'system'.
     * If the performed by user is not set, it defaults to the current authenticated user's ID.
     * If the subject is not set, it defaults to null.
     * If the causer is not set, it defaults to the current authenticated user's username.
     * If the IP address is not set, it defaults to the IP address from the current request.
     * Finally, it saves the activity log to the database.
     *
     * @return void
     */
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
