<div>
    <div class="md:mx-20">
        @foreach($notifications as $notification)
            @if($notification->dismissed)
                @continue
            @endif

            <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl my-4 border-2 {{ $notification->border }}">
                <div class="card-body">
                    <div class="sm:flex sm:justify-between">
                        <div>
                            <p class="card-title"><i class="{{ $notification->icon }}"></i> {{ $notification->title }}
                            </p>
                            <div
                                class="badge {{ $notification->badge }}">{{ __('pages/admin/notifications/messages.types.' . $notification->type) }}</div>
                        </div>
                        <div class="flex gap-2">
                            <i class="icon-clock text-xl"></i>
                            {{ $notification->created_at->diffForHumans() }}
                            @if($notification->dismissible)
                                <i class="icon-x text-red-600 text-xl cursor-pointer"
                                   wire:click="dismissNotification('{{ $notification->id }}')"></i>
                            @endif
                        </div>
                    </div>
                    @if($notification->message)
                        <div class="divider"></div>
                        {!! \Illuminate\Support\Str::markdown($notification->message) !!}
                    @endif
                    @if($notification->files)
                        <div class="divider"></div>
                    @endif

                    <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-4">
                        @if($notification->files != null)
                            @foreach($notification->files as $file)
                                <div class="card bordered">
                                    <figure class="mt-4">
                                        @if($file->isImage)
                                            <img
                                                src="{{ asset('storage/notifications/' . $notification->id . '/' . $file->path) }}"
                                                alt="{{ $file->name }}" class="w-32 h-32 object-cover">
                                        @else
                                            <i class="icon-file text-7xl"></i>
                                        @endif
                                    </figure>
                                    <div class="card-body flex flex-col items-center justify-center">
                                        <p class="font-semibold">{{ $file->name }}</p>
                                    </div>
                                    <div class="justify-end card-actions mb-4 mr-4">
                                        <button type="button" class="btn btn-outline btn-success btn-sm"
                                                wire:click="downloadFile('{{ $notification->id }}', '{{ $file->name }}')">
                                            <i class="icon-download"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
