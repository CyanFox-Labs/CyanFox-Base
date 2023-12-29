<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.upload_profile_image.title') }}</h2>
        <p class="mb-3">{{ __('pages/account/modals.upload_profile_image.description') }}</p>

        <div class="flex justify-center">
            <div class="form-control w-full max-w-xs">
                <div class="mx-auto">
                    <img
                        src="{{ $profileImage?->temporaryUrl() ?? '' . auth()->user()->getProfileImageURL() }}"
                        alt="profile_image"
                        class="h-20 w-20 mb-5 rounded-3xl mx-auto"/>
                </div>

                <x-file wire:model="profileImage" accept="image/png, image/jpeg"
                        label="{{ __('pages/account/modals.upload_profile_image.label') }}"></x-file>
            </div>
        </div>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog" class="flex gap-2" wire:submit="uploadProfileImage">
            <button class="btn btn-neutral" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <button class="btn btn-error" type="button"
                    wire:click="resetImage">{{ __('pages/account/modals.upload_profile_image.buttons.reset_image') }}</button>
            <x-button class="btn btn-success"
                      type="submit"
                      spinner="uploadProfileImage">{{ __('pages/account/modals.upload_profile_image.buttons.upload_profile_image') }}</x-button>
        </form>
    </div>
</x-modal>
