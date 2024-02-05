<div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <span
                class="font-bold text-xl">{{ __('pages/admin/notifications/update_notification.title', ['name' => $notification->title]) }}</span>
            <div class="divider"></div>

            <x-form wire:submit="updateNotification">
                @csrf

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <x-input label="{{ __('pages/admin/notifications/messages.title') }}"
                             class="input input-bordered w-full" wire:model="title" required/>

                    <x-select label="{{ __('pages/admin/notifications/messages.type') }}" wire:model="type"
                              class="select select-bordered"
                              :options="
                                  [['id' => 'info', 'name' => __('pages/admin/notifications/messages.types.info')],
                                  ['id' => 'update', 'name' => __('pages/admin/notifications/messages.types.update')],
                                  ['id' => 'success', 'name' => __('pages/admin/notifications/messages.types.success')],
                                  ['id' => 'warning', 'name' => __('pages/admin/notifications/messages.types.warning')],
                                  ['id' => 'danger', 'name' => __('pages/admin/notifications/messages.types.danger')]]"
                              required></x-select>

                    <x-select label="{{ __('pages/admin/notifications/messages.dismissible') }}"
                              wire:model="dismissible"
                              class="select select-bordered"
                              :options="
                                  [['id' => '1', 'name' => __('messages.yes')],
                                  ['id' => '0', 'name' => __('messages.no')]]"
                              required></x-select>

                    <x-select label="{{ __('pages/admin/notifications/messages.location') }}" wire:model="location"
                              class="select select-bordered"
                              :options="
                                  [['id' => 'home', 'name' => __('pages/admin/notifications/messages.locations.home')],
                                  ['id' => 'notificationsTab', 'name' => __('pages/admin/notifications/messages.locations.notificationsTab')]]"
                              required></x-select>
                </div>

                {{ $this->getForm('messageContent') }}

                <div class="overflow-x-auto mt-4">
                    <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-4">
                        @foreach($uploadedAttachments as $path)
                            @php
                                $file = basename($path);
                                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                            @endphp
                            <div class="card bordered">
                                <figure class="mt-4">

                                    @if($fileExtension === 'png' || $fileExtension === 'jpg' || $fileExtension === 'jpeg')
                                        <img src="{{ asset('storage/' . $path) }}" alt="{{ $file }}"
                                             class="w-32 h-32 object-cover">
                                    @else
                                        <i class="icon-file text-7xl"></i>
                                    @endif
                                </figure>
                                <div class="card-body flex flex-col items-center justify-center">
                                    <p class="card-title">{{ $file }}</p>
                                </div>
                                <div class="justify-end card-actions mb-4 mr-4">
                                    <button type="button" class="btn btn-outline btn-error"
                                            wire:click="removeAttachmentFromTemp('{{ $file }}')">
                                        <i class="icon-x"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        @foreach($storedAttachments as $path)
                            @php
                                $file = basename($path);
                                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                            @endphp
                            <div class="card bordered">
                                <figure class="mt-4">

                                    @if($fileExtension === 'png' || $fileExtension === 'jpg' || $fileExtension === 'jpeg')
                                        <img src="{{ asset('storage/' . $path) }}" alt="{{ $file }}"
                                             class="w-32 h-32 object-cover">
                                    @else
                                        <i class="icon-file text-7xl"></i>
                                    @endif
                                </figure>
                                <div class="card-body flex flex-col items-center justify-center">
                                    <p class="card-title">{{ $file }}</p>
                                </div>
                                <div class="justify-end card-actions mb-4 mr-4">
                                    <button type="button" class="btn btn-outline btn-error"
                                            wire:click="removeAttachment('{{ $file }}')">
                                        <i class="icon-x"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">

                    <x-file label="{{ __('pages/admin/notifications/messages.attachments') }}"
                            wire:model="attachments"
                            multiple="">
                    </x-file>
                </div>


                <div class="md:flex gap-2">
                    <x-button type="button"
                              wire:click="uploadAttachmentsToTemp"
                              class="btn btn-info mt-3" spinner>
                        {{ __('pages/admin/notifications/messages.buttons.upload_attachments') }}
                    </x-button>

                    <x-button type="button"
                              wire:click="$dispatch('openModal', { component: 'components.modals.icon-selector' })"
                              class="btn btn-ghost btn-outline mt-3" spinner>
                        <i class="{{ $icon }}"></i>
                    </x-button>
                </div>

                <div class="divider mt-4"></div>

                <div class="mt-2 flex justify-start gap-3">
                    <a class="btn btn-neutral" type="button"
                       href="{{ route('admin.notifications') }}">{{ __('messages.buttons.back') }}</a>

                    <x-button class="btn btn-success"
                              type="submit" spinner="updateNotification">
                        {{ __('messages.buttons.update') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
