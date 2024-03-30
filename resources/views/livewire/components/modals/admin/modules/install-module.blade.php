<x-modal class="modal-bottom sm:modal-middle">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('admin/modules.modals.install_module.title') }}</h2>
        <p class="mb-3">{{ __('admin/modules.modals.install_module.description') }}</p>
    </div>

    <div class="flex justify-center mb-3">
        <x-file name="module" label="{{ __('admin/modules.modals.install_module.module') }}" wire:model="module" />
    </div>

    <div class="divider"></div>

    <div class="mt-2 flex justify-between gap-3">

        <button class="btn btn-neutral flex-grow" type="button"
                wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>
        <x-button class="btn btn-success flex-grow" type="button"
                  wire:click="installModule"  >{{ __('admin/modules.modals.install_module.buttons.install_module') }}</x-button>
    </div>
</x-modal>

