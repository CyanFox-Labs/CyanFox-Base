<?php

namespace App\Livewire\Components\Tables\Admin;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Notification;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class NotificationsTable extends DataTableComponent
{
    protected $model = Notification::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setConfigurableAreas([
            'toolbar-left-start' => 'components.tables.admin.create-notification'
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.table.id'), 'id')
                ->sortable(),
            Column::make(__('pages/admin/notifications/notifications.table.title'), 'title')
                ->sortable(),
            Column::make(__('pages/admin/notifications/notifications.table.message'), 'message')
                ->sortable(),
            Column::make(__('pages/admin/notifications/notifications.table.type'), 'type')
                ->sortable(),
            Column::make(__('pages/admin/notifications/notifications.table.icon'), 'icon')
                ->sortable()
                ->format(fn($value) => '<i class="' . $value . ' text-lg"></i>')
                ->html(),
            BooleanColumn::make(__('pages/admin/notifications/notifications.table.dismissible'), 'dismissible')
                ->sortable(),
            Column::make(__('pages/admin/notifications/notifications.table.location'), 'location')
                ->sortable(),
            Column::make(__('messages.table.created_at'), 'created_at')
                ->sortable(),
            Column::make(__('messages.table.updated_at'), 'updated_at')
                ->sortable(),
            Column::make(__('messages.table.actions'))
                ->label(function ($row) {
                    return
                        '<a href="' . route('admin.notifications.update', ['notificationId' => $row->id]) . '"><i class="icon-pen font-semibold text-lg text-blue-600 px-2"></i></a>' .
                        '<i wire:click="$dispatch(`openModal`, { component: `components.modals.admin.notifications.delete-notification`,
                        arguments: { notificationId: `' . $row->id . '` } })" class="icon-trash font-semibold text-lg text-red-600 cursor-pointer"></i>';
                })
                ->html(),
        ];
    }
}
