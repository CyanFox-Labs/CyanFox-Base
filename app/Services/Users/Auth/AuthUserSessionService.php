<?php

namespace App\Services\Users\Auth;

use App\Models\Session;

class AuthUserSessionService
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }


    public function findSession(string $sessionId)
    {
        return Session::find($sessionId);
    }

    public function getAllSessionsFromUser()
    {
        return Session::where('user_id', $this->user->id)->get();
    }

    public function getAllSessions()
    {
        return Session::all();
    }

    public function deleteSession(string $sessionId)
    {
        return Session::where('id', $sessionId)->delete();
    }

    public function revokeOtherSessions()
    {
        Session::where('user_id', $this->user->id)
            ->whereNotIn('id', [\Illuminate\Support\Facades\Session::getId()])
            ->delete();
    }
}
