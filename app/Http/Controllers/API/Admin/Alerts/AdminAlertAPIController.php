<?php

namespace App\Http\Controllers\API\Admin\Alerts;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;

#[Group("Admin", "Admin Management")]
#[Subgroup("Alerts", "Manage Alerts")]
#[Authenticated]
class AdminAlertAPIController extends Controller
{

    public function getAllAlerts()
    {
        return Alert::all();
    }

    public function getAlert($alertId)
    {
        return Alert::find($alertId);
    }

    #[BodyParam("title", description: "Title of the alert", example: "New Update")]
    #[BodyParam("type", description: "Type of the alert", example: "info", enum: ["info", "warning", "update", "important"])]
    #[BodyParam("icon", description: "Icon of the alert (See lucide.dev)", example: "icon-bell")]
    #[BodyParam("message", description: "Message of the alert", required: false, example: "**I support markdown**")]
    #[BodyParam("files", description: "Files attached to the alert", required: false, example: "file.txt")]
    public function createAlert(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'type' => 'required|string|in:info,warning,update,important',
            'icon' => 'required|string',
            'message' => 'nullable|string',
            'files' => 'nullable|array|file',
        ]);

        $alert = new Alert();
        $alert->title = $request->input('title');
        $alert->type = $request->input('type');
        $alert->icon = $request->input('icon');
        if ($request->input('message')) {
            $alert->message = $request->input('message');
        }

        try {
            $alert->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create alert',
                'errors' => [
                    'alert' => $e->getMessage(),
                ],
            ], 500);
        }

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                Storage::disk('public')->putFileAs('alerts/' . $alert->id, $file, $file->getClientOriginalName());
            }
        }

        activity('system')
            ->performedOn($alert)
            ->causedBy(auth()->user())
            ->withProperty('name', $alert->title . ' (' . $alert->type . ')')
            ->withProperty('ip', request()->ip())
            ->log('alert.created');

        return $alert;
    }

    #[BodyParam("title", description: "Title of the alert", required: false, example: "New Update")]
    #[BodyParam("type", description: "Type of the alert", required: false, example: "info", enum: ["info", "warning", "update", "important"])]
    #[BodyParam("icon", description: "Icon of the alert (See lucide.dev)", required: false, example: "icon-bell")]
    #[BodyParam("message", description: "Message of the alert", required: false, example: "**I support markdown**")]
    #[BodyParam("files", description: "Files attached to the alert", required: false, example: "file.txt")]
    public function updateAlert($alertId, Request $request)
    {
        $alert = Alert::find($alertId);
        if (!$alert) {
            return response()->json([
                'message' => 'Alert not found'
            ], 404);
        }

        $this->validate($request, [
            'title' => 'nullable|string',
            'type' => 'nullable|string|in:info,warning,update,important',
            'icon' => 'nullable|string',
            'message' => 'nullable|string',
            'files' => 'nullable|array|file',
        ]);

        if ($request->input('title')) $alert->title = $request->input('title');
        if ($request->input('type')) $alert->type = $request->input('type');
        if ($request->input('icon')) $alert->icon = $request->input('icon');
        if ($request->input('message')) $alert->message = $request->input('message');

        try {
            $alert->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update alert',
                'errors' => [
                    'alert' => $e->getMessage(),
                ],
            ], 500);
        }

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            Storage::disk('public')->deleteDirectory('alerts/' . $alert->id);
            foreach ($files as $file) {
                Storage::disk('public')->putFileAs('alerts/' . $alert->id, $file, $file->getClientOriginalName());
            }
        }

        activity('system')
            ->performedOn($alert)
            ->causedBy(auth()->user())
            ->withProperty('name', $alert->title . ' (' . $alert->type . ')')
            ->withProperty('ip', request()->ip())
            ->log('alert.updated');

        return $alert;
    }

    public function deleteAlert($alertId)
    {
        $alert = Alert::find($alertId);
        if (!$alert) {
            return response()->json([
                'message' => 'Alert not found'
            ], 404);
        }

        try {
            $alert->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete alert',
                'errors' => [
                    'alert' => $e->getMessage(),
                ],
            ], 500);
        }

        Storage::disk('public')->deleteDirectory('alerts/' . $alert->id);

        activity('system')
            ->performedOn($alert)
            ->causedBy(auth()->user())
            ->withProperty('name', $alert->title . ' (' . $alert->type . ')')
            ->withProperty('ip', request()->ip())
            ->log('alert.deleted');

        return response()->json([
            'message' => 'Alert deleted'
        ]);
    }

}
