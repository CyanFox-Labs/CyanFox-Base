<?php

namespace App\Livewire\Components\Tables\Admin;

use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

class GroupsTable extends DataTableComponent
{
    protected $model = Role::class;

    #[On('refresh')]
    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'components.tables.admin.create-group'
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.table.id'), 'id')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/admin/groups/groups.table.name'), 'name')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/admin/groups/groups.table.guard_name'), 'guard_name')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.table.created_at'), 'created_at')
                ->sortable(),
            Column::make(__('messages.table.updated_at'), 'updated_at')
                ->sortable(),
            Column::make(__('messages.table.actions'))
                ->label(function ($row) {

                    if ($row->name !== 'Super Admin') {
                        return
                            '<a href="' . route('admin.groups.update', ['groupId' => $row->id]) . '"><i class="icon-pen font-semibold text-lg text-blue-600 px-2"></i></a>' .
                            '<i wire:click="$dispatch(`openModal`, { component: `components.modals.admin.groups.delete-group`,
                        arguments: { groupId: `' . $row->id . '` } })" class="icon-trash font-semibold text-lg text-red-600 cursor-pointer"></i>';
                    }

                    return null;
                })
                ->html(),
        ];
    }
}
