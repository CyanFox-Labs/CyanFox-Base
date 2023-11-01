<?php

namespace App\Livewire\Components\Tables\Admin;

use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Spatie\Permission\Models\Role;

final class RoleList extends PowerGridComponent
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

    public function header(): array
    {
        return [
            Button::add('new-role')
                ->slot('<i class="bx bxs-plus-circle"></i> ' . __('pages/admin/roles/role-list.create'))
                ->class('btn btn-accent')
                ->dispatch('new-role', [])
        ];
    }

    public function datasource(): Builder
    {
        return Role::query();
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('guard_name');
    }

    public function columns(): array
    {
        return [
            Column::make(__('pages/admin/roles/role-list.id'), 'id')
                ->searchable()
                ->sortable(),

            Column::make(__('pages/admin/roles/all.name'), 'name')
                ->searchable()
                ->sortable(),

            Column::make(__('pages/admin/roles/all.guard_name'), 'guard_name')
                ->searchable()
                ->sortable(),

            Column::action(__('pages/admin/roles/role-list.actions'))
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->redirect(route('admin-role-edit', [$rowId]));
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void
    {
        $this->dispatch('openModal', 'components.modals.admin.role-delete', ['roleId' => $rowId]);
    }

    #[\Livewire\Attributes\On('new-role')]
    public function createRole(): void
    {
        $this->redirect(route('admin-role-create'));
    }

    public function actions(Role $row): array
    {
        return [
            Button::add('edit')
                ->slot('<i class="bx bxs-edit-alt"></i>')
                ->id()
                ->class('btn btn-primary btn-sm')
                ->dispatch('edit', ['rowId' => $row->id]),
            Button::add('delete')
                ->slot('<i class="bx bxs-trash-alt text-white"></i>')
                ->id()
                ->class('btn btn-error btn-sm')
                ->dispatch('delete', ['rowId' => $row->id]),
        ];
    }
}
