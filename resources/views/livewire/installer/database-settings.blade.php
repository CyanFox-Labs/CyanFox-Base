<div>
    <x-form wire:submit="saveDatabaseSettings">

        @if($alert)
            <div role="alert" class="alert alert-{{ $alert['type'] }}">
                @if($alert['type'] == 'error')
                    <i class="icon-x-octagon text-2xl"></i>
                @endif
                @if($alert['type'] == 'success')
                    <i class="icon-check-circle text-2xl"></i>
                @endif
                <div>
                    <h3>{{ $alert['title'] }}</h3>
                    <div class="text-sm">{{ $alert['message'] }}</div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] gap-4 mb-5">
            <x-input label="{{ __('pages/installer.database.host') }}" class="input-bordered" wire:model="host" required/>
            <x-input label="{{ __('pages/installer.database.port') }}" class="input-bordered" wire:model="port" required/>
            <x-input label="{{ __('pages/installer.database.database') }}" class="input-bordered"
                     wire:model="database" required/>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-1">
            <x-input label="{{ __('pages/installer.database.username') }}" class="input-bordered"
                     wire:model="username" required/>
            <x-input label="{{ __('pages/installer.database.password') }}" class="input-bordered" type="password"
                     wire:model="password" required/>
        </div>

        <div class="divider"></div>

        <div class="mt-2 flex justify-between gap-3">
            <x-button class="btn btn-primary"
                      type="button" wire:click="testConnection" spinner>
                {{ __('pages/installer.database.buttons.test') }}
            </x-button>
            <x-button class="btn btn-success"
                      type="submit" spinner="saveDatabaseSettings">
                {{ __('pages/installer.buttons.next') }}
            </x-button>
        </div>
    </x-form>
</div>
