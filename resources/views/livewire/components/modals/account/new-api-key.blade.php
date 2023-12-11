<x-modal class="modal-bottom sm:modal-middle">

    @if(!$plainTextToken)
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.new_api_key.title') }}</h2>
            <p class="mb-3">{{ __('pages/account/modals.new_api_key.description') }}</p>
        </div>
        <div class="flex justify-center">
            <div class="form-control w-full max-w-xs">
                <x-input label="{{ __('messages.name') }}"
                         type="text"
                         wire:model="name"
                         class="input input-bordered w-full max-w-xs mb-4"/>
            </div>
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog" class="flex gap-2" wire:submit="createAPIKey">
                <button class="btn btn-neutral" type="button"
                        wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
                <x-button class="btn btn-danger"
                          type="submit"
                          spinner="logoutSession">{{ __('pages/account/modals.new_api_key.buttons.create_api_key') }}
                </x-button>
            </form>
        </div>
    @else

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.new_api_key.created.title') }}</h2>
            <p class="mb-3">{{ __('pages/account/modals.new_api_key.created.description') }}</p>
        </div>
        <div class="flex justify-center">
            {{ $plainTextToken }}
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog" class="flex gap-2">
                <x-button class="btn btn-danger" onclick="location.reload();"
                          type="submit" wire:click="$dispatch('closeModal');">{{ __('messages.ok') }}
                </x-button>
            </form>
        </div>

    @endif
</x-modal>
