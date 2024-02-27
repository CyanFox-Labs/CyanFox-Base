<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\SettingsManager;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group('Admin', 'Admin Management')]
#[Subgroup('Settings', 'Manage Settings')]
#[Authenticated]
class AdminSettingsAPIController
{
    public function getAllSettings(): Collection
    {
        return Setting::all();
    }

    public function getSetting(string $key): string
    {
        $setting = SettingsManager::getSetting($key);

        if (!$setting) {
            return response()->json([
                'message' => 'Setting not found',
            ], 404);
        }

        return $setting;
    }

    #[BodyParam('keys', description: 'Keys of the setting', example: ['app_name', 'app_description'])]
    #[BodyParam('values', description: 'Values of the setting', example: ['My App', 'My App Description'])]
    public function updateSettings(Request $request): JsonResponse
    {
        $keys = $request->input('keys');
        $values = $request->input('values');
        $settings = [];

        foreach ($keys as $index => $key) {
            $settings[$key] = $values[$index];
        }

        SettingsManager::updateSettings($settings);

        return response()->json([
            'message' => 'Settings updated successfully',
        ]);
    }

    #[BodyParam('key', description: 'Key of the setting', example: 'app_name')]
    #[BodyParam('value', description: 'Value of the setting', example: 'My App')]
    public function updateSetting(Request $request): string
    {
        SettingsManager::updateSetting($request->input('key'), $request->input('value'));

        return SettingsManager::getSetting($request->input('key'));
    }
}
