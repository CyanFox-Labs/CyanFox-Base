<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group("Admin", "Admin Management")]
#[Subgroup("Settings", "Manage Settings")]
#[Authenticated]
class AdminSettingsAPIController
{

    public function getAllSettings()
    {
        return Setting::all();
    }

    public function getSetting($key)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return response()->json([
                'message' => 'Setting not found'
            ], 404);
        }

        return $setting;
    }

    #[BodyParam("keys", description: "Keys of the setting", example: ["app_name", "app_description"])]
    #[BodyParam("values", description: "Values of the setting", example: ["My App", "My App Description"])]
    public function updateSettings(Request $request)
    {
        $keys = $request->input('keys');
        $values = $request->input('values');

        if (is_array($keys) && is_array($values)) {
            $settings = array_combine($keys, $values);

            foreach ($settings as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
            }

            return response()->json([
                'message' => 'Settings updated successfully'
            ]);
        }

        return response()->json([
            'message' => 'Invalid input data!'
        ], 400);
    }

    #[BodyParam("key", description: "Key of the setting", example: "app_name")]
    #[BodyParam("value", description: "Value of the setting", example: "My App")]
    public function updateSetting(Request $request)
    {
        Setting::where('key', $request->input('key'))->update(['value' => $request->input('value')]);

        return Setting::where('key', $request->input('key'))->first();
    }

}
