<?php

namespace App\Livewire\Components\Tables\Account;

use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Jenssegers\Agent\Agent;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Session;

class SessionsTable extends DataTableComponent
{

    public function builder(): Builder
    {
        return Session::query()->where('user_id', auth()->user()->id);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setConfigurableAreas([
            'toolbar-left-start' => 'components.tables.account.logout-other-devices'
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.table.id'), 'id')
                ->hideIf(true),
            Column::make(__('pages/account/profile.sessions.table.ip_address'), 'ip_address')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/account/profile.sessions.table.user_agent'), 'user_agent')
                ->searchable()
                ->sortable(),
            Column::make(__('pages/account/profile.sessions.table.device'), 'user_agent')
                ->sortable()
                ->format(function ($userAgent) {
                    $agent = new Agent;
                    $agent->setUserAgent($userAgent);

                    if ($agent->isDesktop()) {
                        return '<i class="icon-monitor"></i> ' . __('pages/account/profile.sessions.device_types.desktop');
                    } else if ($agent->isPhone()) {
                        return ($agent->isPhone() ? '<i class="icon-smartphone"></i> ' . __('pages/account/profile.sessions.device_types.phone') :
                            '<i class="icon-tablet"></i> ' . __('pages/account/profile.sessions.device_types.tablet'));
                    } else {
                        return '<i class="icon-monitor-smartphone text-lg"></i> ' . __('pages/account/profile.sessions.device_types.unknown');
                    }
                })->html(),
            Column::make(__('pages/account/profile.sessions.table.last_activity'), 'last_activity')
                ->sortable()
                ->format(function ($lastActivity) {
                    return Carbon::createFromTimestamp($lastActivity)->diffForHumans();
                }),

            Column::make('Action')
                ->label(function ($row) {
                    if ($row->id !== session()->getId()) {
                        return '<i wire:click="logout(`' . $row->id . '`)" class="icon-log-out font-semibold text-lg text-orange-600 cursor-pointer"></i>';
                    }
                    return '<span class="badge badge-success">' . __('pages/account/profile.sessions.current_session') . '</span>';
                })
                ->html(),
        ];
    }

    public function logoutOtherDevices()
    {

        Session::logoutOtherDevices();

        Notification::make()
            ->title(__('pages/account/profile.notifications.logged_out_other_devices'))
            ->success()
            ->send();
    }

    public function logout($id)
    {
        $session = Session::where('id', $id)->first();

        if ($session === null) {
            return;
        }

        $session->delete();

        Notification::make()
            ->title(__('pages/account/profile.notifications.session_logged_out'))
            ->success()
            ->send();
    }
}
