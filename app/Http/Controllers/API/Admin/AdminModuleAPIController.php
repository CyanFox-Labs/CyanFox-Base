<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Module;

#[Group("Admin", "Admin Management")]
#[Subgroup("Modules", "Manage Modules")]
#[Authenticated]
class AdminModuleAPIController extends Controller
{

    public function getAllModules()
    {
        return Module::all();
    }

    public function getModule($moduleName)
    {
        $module = Module::findOrFail($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found'
            ], 404);
        }

        return $module;
    }

    public function enableModule($moduleName)
    {
        $module = Module::findOrFail($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found'
            ], 404);
        }

        $module->enable();

        return response()->json([
            'message' => 'Module enabled successfully'
        ]);
    }

    public function disableModule($moduleName)
    {
        $module = Module::findOrFail($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found'
            ], 404);
        }

        $module->disable();

        return response()->json([
            'message' => 'Module disabled successfully'
        ]);
    }

    public function deleteModule($moduleName)
    {
        $module = Module::findOrFail($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found'
            ], 404);
        }

        $module->delete();

        return response()->json([
            'message' => 'Module deleted successfully'
        ]);
    }

}
