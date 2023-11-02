<x-modal class="modal-bottom sm:modal-middle">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/admin/roles/modals.delete.title') }}</h2>
        <p class="mb-3">{{ __('pages/admin/roles/modals.delete.description') }}</p>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog">
            <button class="btn btn-neutral" wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <a role="button" wire:click="deleteRole"
               class="btn btn-error">{{ __('pages/admin/roles/modals.delete.buttons.delete_role') }}</a>
        </form>
    </div>
</x-modal>
