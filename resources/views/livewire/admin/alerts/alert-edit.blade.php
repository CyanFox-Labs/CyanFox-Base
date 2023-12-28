<div>
    <script src="{{ asset('js/sites/markdown.js') }}"></script>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i
                            class="icon-settings mr-2"></i> {{ __('navigation/messages.admin') }}
                    </a></li>
                <li><a href="{{ route('admin-alert-list') }}"><i
                            class="icon-message-circle-warning mr-2"></i> {{ __('messages.alerts') }}</a></li>
                <li><a href="{{ route('admin-alert-edit', $alertId) }}"><i
                            class="icon-pen mr-2"></i> {{ __('navigation/breadcrumbs.admin.alerts.edit') }}
                    </a></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
        <div class="card-body">

            <form wire:submit="createAlert" onsubmit="sendToLivewire()">

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.title') }}"
                                 class="input input-bordered w-full" wire:model="title" required/>
                    </div>
                    <div class="form-control w-full">
                        <x-select label="{{ __('messages.type') }}" wire:model="type"
                                  class="select select-bordered"
                                  :options="
                                      [['id' => 'info', 'name' => __('pages/admin/alerts/messages.types.info')],
                                      ['id' => 'warning', 'name' => __('pages/admin/alerts/messages.types.warning')],
                                      ['id' => 'update', 'name' => __('pages/admin/alerts/messages.types.update')],
                                      ['id' => 'important', 'name' => __('pages/admin/alerts/messages.types.important')]]"></x-select>
                    </div>
                    <div class="form-control w-full">
                        <div class="flex gap-2 mt-4">
                            <button type="button" class="btn btn-ghost"
                                    wire:click="$dispatch('openModal', { component: 'components.modals.admin.alerts.icon-selector' })">
                                <i class="{{ $icon }}"></i>
                            </button>
                            <button type="button"
                                    wire:click="$dispatch('openModal', { component: 'components.modals.admin.alerts.icon-selector' })"
                                    class="btn btn-accent">
                            {{ __('pages/admin/alerts/messages.buttons.select_icon') }}
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto" wire:ignore>

                    <label class="form-control">
                        <div class="label">
                            <span class="label-text font-semibold">{{ __('messages.message') }}</span>
                        </div>
                        <textarea id="editor" wire:model="message"></textarea>
                    </label>
                </div>

                <div class="col-span-1 mt-6 space-x-2 space-y-2">

                    <a href="{{ route('admin-user-list') }}"
                       class="btn btn-error">
                        {{ __('messages.back') }}
                    </a>
                    <x-button type="submit"
                              class="btn btn-primary" spinner="updateAlert">
                        {{ __('pages/admin/alerts/messages.buttons.update_alert') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
