<div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <span class="font-bold text-xl">{{ __('pages/admin/groups/update_group.title', ['group' => $group->name]) }}</span>
            <div class="divider"></div>

            <x-form wire:submit="updateGroup">
                @csrf

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <x-input label="{{ __('pages/admin/groups/messages.name') }}"
                             class="input input-bordered w-full" wire:model="name" required/>

                    <x-input label="{{ __('pages/admin/groups/messages.guard_name') }}"
                             class="input input-bordered w-full" wire:model="guardName" required/>
                </div>

                <x-custom.multi-select label="{{ __('pages/admin/groups/messages.permissions') }}"
                                       wire:model="selectedPermissions" :options="$permissions"/>

                <div class="divider mt-4"></div>

                <div class="mt-2 flex justify-start gap-3">
                    <a class="btn btn-neutral" type="button"
                       href="{{ route('admin.groups') }}" wire:navigate>{{ __('messages.buttons.back') }}</a>

                    <x-button class="btn btn-success"
                              type="submit" spinner="updateGroup">
                        {{ __('messages.buttons.save') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
