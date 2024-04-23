<?php

namespace App\Livewire\Components\Tables\Account;

use App\Facades\UserManager;
use App\Models\Session;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SessionsTable extends DataTableComponent
{
    #[On('refresh')]
    public function builder(): Builder
    {
        return Session::query()->where('user_id', Auth::user()->id);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setConfigurableAreas([
            'toolbar-left-start' => 'components.tables.account.logout-other-devices',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.table.id'), 'id')
                ->hideIf(true),
            Column::make(__('account/profile.sessions.table.ip_address'), 'ip_address')
                ->searchable()
                ->sortable(),
            Column::make(__('account/profile.sessions.table.user_agent'), 'user_agent')
                ->searchable()
                ->sortable(),
            Column::make(__('account/profile.sessions.table.device'), 'user_agent')
                ->sortable()
                ->format(function ($userAgent) {
                    $agent = new Agent;
                    $agent->setUserAgent($userAgent);

                    if ($agent->isDesktop()) {
                        return '<i class="icon-monitor"></i> '.__('account/profile.sessions.device_types.desktop');
                    } elseif ($agent->isPhone()) {
                        return $agent->isPhone() ? '<i class="icon-smartphone"></i> '.__('account/profile.sessions.device_types.phone') :
                            '<i class="icon-tablet"></i> '.__('account/profile.sessions.device_types.tablet');
                    } else {
                        return '<i class="icon-monitor-smartphone text-lg"></i> '.__('account/profile.sessions.device_types.unknown');
                    }
                })->html(),
            Column::make(__('account/profile.sessions.table.last_activity'), 'last_activity')
                ->sortable()
                ->format(function ($lastActivity) {
                    return Carbon::createFromTimestamp($lastActivity)->diffForHumans();
                }),

            Column::make('Action')
                ->label(function ($row) {
                    if ($row->id !== session()->getId()) {
                        return '<i wire:click="logout(`'.$row->id.'`)" class="icon-log-out font-semibold text-lg text-orange-600 cursor-pointer"></i>';
                    }

                    return '<span class="badge badge-success">'.__('account/profile.sessions.current_session').'</span>';
                })
                ->html(),
        ];
    }

    public function logout($id)
    {
        UserManager::getUser(Auth::user())->getSessionManager()->deleteSession($id);

        Notification::make()
            ->title(__('account/profile.sessions.notifications.session_logged_out'))
            ->success()
            ->send();
    }
}
