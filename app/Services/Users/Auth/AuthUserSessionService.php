<?php

namespace App\Services\Users\Auth;

use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Session_C;

class AuthUserSessionService
{
    /**
     * This variable represents the user object.
     *
     * @var User
     */
    private $user;

    /**
     * Constructor method for initializing the user.
     *
     * @param  mixed  $user  The user object or user identifier.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Finds a session based on the given session ID.
     *
     * @param  string  $sessionId  The session ID to search for.
     * @return Session|null The found session object. Returns null if the session is not found.
     */
    public function findSession(string $sessionId): ?Session
    {
        return Session::find($sessionId);
    }

    /**
     * Retrieve all sessions from the user.
     *
     * @return _IH_Session_C|Session[]
     */
    public function getAllSessionsFromUser(): _IH_Session_C
    {
        return Session::where('user_id', $this->user->id)->get();
    }

    /**
     * Retrieves all sessions from the database.
     *
     * @return Collection|Session[] List of all sessions in the database.
     */
    public function getAllSessions(): Collection|array
    {
        return Session::all();
    }

    /**
     * Deletes a session for the current user.
     *
     * @param  string  $sessionId  The ID of the session to be deleted.
     */
    public function deleteSession(string $sessionId): bool
    {
        return Session::where('id', $sessionId)->where('user_id', $this->user->id)->delete();
    }

    /**
     * Revoke other sessions for the current user.
     *
     * This method revokes all sessions except the current one for the user.
     * It finds all sessions related to the user and deletes them from the database.
     */
    public function revokeOtherSessions(): void
    {
        Session::where('user_id', $this->user->id)
            ->whereNotIn('id', [\Illuminate\Support\Facades\Session::getId()])
            ->delete();
    }
}
