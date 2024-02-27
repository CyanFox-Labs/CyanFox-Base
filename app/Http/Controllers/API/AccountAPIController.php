<?php

namespace App\Http\Controllers\API;

use App\Facades\UserManager;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;

#[Authenticated]
#[Group('Account', 'Account Management')]
class AccountAPIController extends Controller
{
    public function getAccount(Request $request): mixed
    {
        return $request->user();
    }

    public function getActivity(Request $request): Collection
    {
        return ActivityLog::query()->where('performed_by', $request->user()->id)->orderByDesc('created_at')->get();
    }

    public function getPermissions(Request $request): array
    {
        return UserManager::getUser($request->user())->getPermissions();
    }

    public function getGroups(Request $request): array
    {
        return UserManager::getUser($request->user())->getGroups();
    }

    public function getAvatar(Request $request): string
    {
        return UserManager::getUser($request->user())->getAvatarURL();
    }

    public function deleteAccount(Request $request): JsonResponse
    {
        $request->user()->delete();

        return response()->json(['message' => 'Account deleted']);
    }

    #[BodyParam('first_name', description: 'First name of the user', required: false, example: 'John')]
    #[BodyParam('last_name', description: 'Last name of the user', required: false, example: 'Doe')]
    #[BodyParam('username', description: 'Username of the user', required: false, example: 'johndoe')]
    #[BodyParam('email', description: 'Email of the user', required: false, example: 'john.doe@example')]
    #[BodyParam('custom_avatar_url', description: 'Custom avatar URL of the user', required: false, example: 'https://example.com/avatar.png')]
    #[BodyParam('language', description: 'Language of the user', required: false, example: 'en')]
    #[BodyParam('theme', description: 'Theme of the user', required: false, example: 'dark')]
    #[BodyParam('password', description: 'Password of the user', required: false, example: 'password')]
    public function updateAccount(Request $request): mixed
    {
        $this->validate($request, [
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'username' => 'string|nullable',
            'email' => 'email|nullable',
            'custom_avatar_url' => 'url|nullable',
            'language' => 'string|nullable',
            'theme' => 'string|nullable',
            'password' => 'string|nullable',
        ]);

        $request->user()->update([
            'first_name' => $request->input('first_name') ?? $request->user()->first_name,
            'last_name' => $request->input('last_name') ?? $request->user()->last_name,
            'username' => $request->input('username') ?? $request->user()->username,
            'email' => $request->input('email') ?? $request->user()->email,
            'custom_avatar_url' => $request->input('custom_avatar_url') ?? $request->user()->custom_avatar_url,
            'language' => $request->input('language') ?? $request->user()->language,
            'theme' => $request->input('theme') ?? $request->user()->theme,
            'password' => Hash::make($request->input('password')) ?? $request->user()->password,
        ]);

        return $request->user();
    }
}
