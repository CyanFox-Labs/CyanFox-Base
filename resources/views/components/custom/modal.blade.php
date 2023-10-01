@props([
    'name' => 'modal'
])

<dialog id="{{ $name }}" class="modal modal-bottom sm:modal-middle" wire:ignore
        x-data
        x-on:open-modal.window="{{ $name }}.showModal();"
        x-on:close-modal.window="{{ $name  }}.close()">
    <div class="modal-box">
        {{ $slot }}
    </div>
</dialog>
