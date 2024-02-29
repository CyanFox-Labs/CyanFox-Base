<?php

namespace App\Livewire\Components\Tables\Account;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ActivityTable extends DataTableComponent
{
    #[On('refresh')]
    public function builder(): Builder
    {
        return ActivityLog::query()->where('performed_by', Auth::user()->id)->orderBy('created_at', 'desc');
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
            Column::make(__('account/profile.activity.table.log_name'), 'log_name')
                ->sortable()
                ->searchable(),
            Column::make(__('account/profile.activity.table.description'), 'description')
                ->sortable()
                ->searchable(),
            Column::make(__('account/profile.activity.table.subject'), 'subject')
                ->sortable()
                ->searchable(),
            Column::make(__('account/profile.activity.table.causer'), 'causer')
                ->sortable()
                ->searchable(),
            Column::make(__('account/profile.activity.table.ip_address'), 'ip_address')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.table.created_at'), 'created_at')
                ->sortable(),
            Column::make(__('messages.table.updated_at'), 'updated_at')
                ->sortable(),
        ];
    }
}
