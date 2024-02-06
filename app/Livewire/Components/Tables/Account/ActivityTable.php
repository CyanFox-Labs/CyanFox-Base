<?php

namespace App\Livewire\Components\Tables\Account;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ActivityTable extends DataTableComponent
{

    #[On('refresh')]
    public function builder(): Builder
    {
        return ActivityLog::query()->where('performed_by', auth()->id());
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.table.id'), 'id')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/account/profile.activity.table.log_name'), 'log_name')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/account/profile.activity.table.log_message'), 'log_message')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/account/profile.activity.table.subject'), 'subject')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/account/profile.activity.table.causer'), 'causer')
                ->sortable()
                ->searchable(),
            Column::make(__('pages/account/profile.activity.table.ip_address'), 'ip_address')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.table.created_at'), 'created_at')
                ->sortable(),
            Column::make(__('messages.table.updated_at'), 'updated_at')
                ->sortable(),
            Column::make(__('messages.table.actions'))
                ->label(fn($row) => '<i wire:click="$dispatch(`openModal`, { component: `components.modals.show-activity-log-details`,
                        arguments: { activityLogId: `' . $row->id . '` } })" class="icon-eye font-semibold text-lg text-green-600 cursor-pointer"></i>'
                )
                ->html(),
        ];
    }
}
