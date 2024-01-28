<?php

namespace App\Livewire\Components\Tables\Admin;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setConfigurableAreas([
            'toolbar-left-start' => 'components.tables.admin.create-user'
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.table.id'), 'id')
                ->searchable()
                ->sortable(),
            ImageColumn::make(__('pages/admin/users/users.table.avatar'))
                ->location(function ($row) {
                    $user = User::find($row->id);
                    return $user->getAvatarURL();
                })
                ->attributes(function () {
                    return [
                        'class' => 'rounded-full h-7 w-7'
                    ];
                }),
            Column::make(__('pages/admin/users/users.table.username'), 'username')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/admin/users/users.table.first_name'), 'first_name')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/admin/users/users.table.last_name'), 'last_name')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/admin/users/users.table.email'), 'email')
                ->searchable()
                ->sortable(),
            BooleanColumn::make(__('pages/admin/users/users.table.two_factor_enabled'), 'two_factor_enabled')
                ->sortable(),
            BooleanColumn::make(__('pages/admin/users/users.table.force_change_password'), 'force_change_password')
                ->sortable(),
            BooleanColumn::make(__('pages/admin/users/users.table.force_activate_two_factor'), 'force_activate_two_factor')
                ->sortable(),
            BooleanColumn::make(__('pages/admin/users/users.table.disabled'), 'disabled')
                ->sortable(),
            Column::make(__('messages.table.created_at'), 'created_at')
                ->sortable(),
            Column::make(__('messages.table.updated_at'), 'updated_at')
                ->sortable(),
            Column::make(__('messages.table.actions'))
                ->label(function ($row) {

                    if ($row->id === auth()->user()->id) {
                        return '<a href="' . route('admin.users.update', ['userId' => $row->id]) . '"><i class="icon-pen font-semibold text-lg text-blue-600 px-2"></i></a>';
                    }
                    return
                        '<a href="' . route('admin.users.update', ['userId' => $row->id]) . '"><i class="icon-pen font-semibold text-lg text-blue-600 px-2"></i></a>' .
                        '<i wire:click="$dispatch(`openModal`, { component: `components.modals.admin.users.delete-user`,
                        arguments: { userId: `' . $row->id . '` } })" class="icon-trash font-semibold text-lg text-red-600 cursor-pointer"></i>';
                })
                ->html(),
        ];
    }
}
