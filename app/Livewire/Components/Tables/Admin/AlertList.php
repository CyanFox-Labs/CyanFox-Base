<?php

namespace App\Livewire\Components\Tables\Admin;

use App\Models\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AlertList extends PowerGridComponent
{

    public function setUp(): array
    {

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('new-role')
                ->slot('<i class="icon-plus-circle"></i> ' . __('pages/admin/alerts/messages.buttons.new_alert'))
                ->class('btn btn-accent')
                ->dispatch('new-alert', [])
        ];
    }

    public function datasource(): Builder
    {
        return Alert::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('message', function ($row) {
                $row->message = $row->message ? Str::markdown(substr($row->message, 0, 70)) : "";
                if (strlen($row->message) < 100)
                    return $row->message;
                else
                    return  $row->message . '...';
            })
            ->addColumn('type', function ($row) {
                return __('pages/admin/alerts/messages.types.' . $row->type);
            })
            ->addColumn('icon', function ($row) {
                return '<i class="' . $row->icon . '"></i>';
            })
            ->addColumn('created_at')
            ->addColumn('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.id'), 'id')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.title'), 'title')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.message'), 'message')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.type'), 'type')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.icon'), 'icon')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.created_at'), 'created_at')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.updated_at'), 'updated_at')
                ->searchable()
                ->sortable(),
            Column::action(__('messages.actions'))
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[On('new-alert')]
    public function createAlert(): void
    {
        $this->redirect(route('admin-alert-create'));
    }

    #[On('edit')]
    public function edit($rowId): void
    {
        $this->redirect(route('admin-alert-edit', [$rowId]));
    }

    #[On('delete')]
    public function delete($rowId): void
    {
        $this->dispatch('openModal', 'components.modals.admin.alerts.alert-delete', ['alertId' => $rowId]);
    }

    public function actions(Alert $row): array
    {
        return [
            Button::add('edit')
                ->slot('<i class="icon-pen"></i>')
                ->id()
                ->class('btn btn-primary btn-sm')
                ->dispatch('edit', ['rowId' => $row->id]),
            Button::add('delete')
                ->slot('<i class="icon-trash"></i>')
                ->id()
                ->class('btn btn-error btn-sm')
                ->dispatch('delete', ['rowId' => $row->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            Rule::rows()
                ->when(function ($row) {
                    return $row->type == 'info';
                })
                ->setAttribute('class', 'bg-blue-200 text-blue-800'),

            Rule::rows()
                ->when(function ($row) {
                    return $row->type == 'warning';
                })
                ->setAttribute('class', 'bg-yellow-200 text-yellow-800'),

            Rule::rows()
                ->when(function ($row) {
                    return $row->type == 'update';
                })
                ->setAttribute('class', 'bg-green-200 text-green-800'),

            Rule::rows()
                ->when(function ($row) {
                    return $row->type == 'important';
                })
                ->setAttribute('class', 'bg-red-200 text-red-800'),
        ];
    }
}
