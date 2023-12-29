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
            Header::make(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Activity::query()->where('log_name', 'system')->orderByDesc('id');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('subject_id', fn(Activity $activity) => $activity->getExtraProperty('name'))
            ->addColumn('causer_id', function (Activity $activity) {
                if ($activity->causer == null) {
                    return __('messages.unknown');
                }
                return $activity->causer->username . ' (' . $activity->causer->email . ')';
            })
            ->addColumn('causer_ip', function (Activity $activity) {
                return $activity->getExtraProperty('ip') ?? __('messages.unknown');
            })
            ->addColumn('description', function (Activity $activity) {
                return __('activity_log/messages.' . $activity->description);
            })
            ->addColumn('created_at', function (Activity $activity) {
                return Carbon::parse($activity->created_at)->format('d-m-Y H:i:s');
            })
            ->addColumn('updated_at', function (Activity $activity) {
                return Carbon::parse($activity->updated_at)->format('d-m-Y H:i:s');
            });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.id'), 'id')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/admin/activity_log.subject'), 'subject_id')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/admin/activity_log.causer'), 'causer_id')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/admin/activity_log.causer_ip'), 'causer_ip'),
            Column::make(__('pages/admin/activity_log.description'), 'description')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.created_at'), 'created_at')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.updated_at'), 'updated_at')
                ->sortable()
                ->searchable(),
        ];
    }
}
