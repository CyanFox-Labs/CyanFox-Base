<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Nwidart\Modules\Facades\Module;

#[Group('Admin', 'Admin Management')]
#[Subgroup('Modules', 'Manage Modules')]
#[Authenticated]
class AdminModuleAPIController extends Controller
{
    public function getAllModules(): array
    {
        return Module::all();
    }

    public function getModule(string $moduleName): \Nwidart\Modules\Module|JsonResponse
    {
        $module = Module::find($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found',
            ], 404);
        }

        return $module;
    }

    public function enableModule(string $moduleName): JsonResponse
    {
        $module = Module::find($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found',
            ], 404);
        }

        $module->enable();

        return response()->json([
            'message' => 'Module enabled successfully',
        ]);
    }

    public function disableModule(string $moduleName): JsonResponse
    {
        $module = Module::find($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found',
            ], 404);
        }

        $module->disable();

        return response()->json([
            'message' => 'Module disabled successfully',
        ]);
    }

    public function deleteModule(string $moduleName): JsonResponse
    {
        $module = Module::find($moduleName);

        if (!$module) {
            return response()->json([
                'message' => 'Module not found',
            ], 404);
        }

        $module->delete();

        return response()->json([
            'message' => 'Module deleted successfully',
        ]);
    }
}
