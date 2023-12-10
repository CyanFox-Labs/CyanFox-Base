<?php

namespace App\Livewire\Components\Tables\Admin;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Spatie\Activitylog\Models\Activity;

final class ActivityLogList extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Activity::query()->where('log_name', 'system');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('subject', function (Activity $activity) {
                return $activity->getExtraProperty('name');
            })
            ->addColumn('causer_id', function (Activity $activity) {
                if ($activity->causer == null) {
                    return __('messages.unknown');
                }
                return $activity->causer->username;
            })
            ->addColumn('causer_ip', function () {
                return request()->ip();
            })
            ->addColumn('description', function (Activity $activity) {
                return __('activity_log/system.' . $activity->description);
            });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.id'), 'id')
                ->sortable(),
            Column::make(__('pages/admin/activity_log.subject'), 'subject'),
            Column::make(__('pages/admin/activity_log.causer'), 'causer_id')
                ->sortable(),
            Column::make(__('pages/admin/activity_log.causer_ip'), 'causer_ip'),
            Column::make(__('pages/admin/activity_log.description'), 'description')
                ->sortable()
                ->searchable(),
        ];
    }
}
