<div>
    <span class="font-bold text-xl">{{ __('admin/modules.title') }}</span>
    <div class="divider"></div>
    @if(count($modules) === 0)
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="text-2xl font-semibold text-center">
                    {{ __('admin/modules.no_modules') }}
                </div>
            </div>
        </div>
    @endif
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach($modules as $module)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="text-2xl font-semibold text-center">
                        {{ $module['name'] }}
                    </div>

                    <div class="text-center">
                        @if($module['enabled'])
                            <div class="badge badge-success">
                                {{ __('admin/modules.enabled') }}
                            </div>
                        @else
                            <div class="badge badge-error">
                                {{ __('admin/modules.disabled') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex mt-4 justify-between">
                        <div>
                            @if($module['hasSettingsPage'])
                                <a href="{{ route('modules.' . $module["name"] . '.settings') }}"
                                   class="btn btn-ghost"><i class="icon-settings-2 text-lg"></i></a>
                            @endif
                        </div>

                        <div>
                            <button
                                    wire:click="$dispatch('openModal', { component: 'components.modals.admin.modules.delete-module', arguments: { moduleName: '{{ $module['name'] }}' }})"
                                    class="btn btn-ghost">
                                <i class="icon-trash text-lg text-red-600"></i>
                            </button>

                            @if($module['enabled'])
                                <button wire:click="disableModule('{{ $module['name'] }}')" class="btn btn-ghost">
                                    <i class="icon-ban text-lg text-yellow-600"></i>
                                </button>
                            @else
                                <button wire:click="enableModule('{{ $module['name'] }}')" class="btn btn-ghost">
                                    <i class="icon-check text-lg text-green-600"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
