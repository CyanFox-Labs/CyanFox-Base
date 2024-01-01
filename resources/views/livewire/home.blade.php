<div>

    <div class="md:mx-20">
        @foreach($alerts as $alert)
            @php
                $files = \Illuminate\Support\Facades\Storage::disk('public')->files('alerts/' . $alert->id);
                $badge;
                $border;

                if ($alert->type == 'info') {
                    $badge = 'bg-blue-500 text-base-100';
                    $border = 'border-blue-500';
                }
                if ($alert->type == 'warning') {
                    $badge = 'bg-yellow-500 text-base-100';
                    $border = 'border-yellow-500';
                }
                if ($alert->type == 'update') {
                    $badge = 'bg-green-500 text-base-100';
                    $border = 'border-green-500';
                }
                if ($alert->type == 'important') {
                    $badge = 'bg-red-500 text-base-100';
                    $border = 'border-red-500';
                }
            @endphp
            <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl my-4 border-2 {{ $border }}">
                <div class="card-body">
                    <div class="sm:flex sm:justify-between">
                        <div>
                            <p class="card-title"><i class="{{ $alert->icon }}"></i> {{ $alert->title }}</p>
                            <div
                                class="badge {{ $badge }}">{{ __('pages/admin/alerts/messages.types.' . $alert->type) }}</div>
                        </div>
                        <div class="flex gap-2">
                            <i class="icon-clock text-xl"></i>
                            {{ $alert->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="divider"></div>

                    {!! $alert->message ? \Illuminate\Support\Str::markdown($alert->message) : "" !!}

                    @if(count($files) !== 0)
                        <div class="divider"></div>
                    @endif


                    <div class="grid lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] md:grid-cols-1 gap-4">
                        @foreach($files as $path)
                            @php
                                $file = basename($path);
                            @endphp
                            <div class="card bordered">
                                <figure class="mt-4">
                                    <i class="icon-file text-4xl"></i>
                                </figure>
                                <div class="card-body flex flex-col items-center justify-center">
                                    <p class="font-semibold">{{ $file }}</p>
                                </div>
                                <div class="justify-end card-actions mb-4 mr-4">
                                    <button type="button" class="btn btn-outline btn-success btn-sm"
                                            wire:click="downloadFile('{{ $path }}', '{{ $file }}')">
                                        <i class="icon-download"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
