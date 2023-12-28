<div>

    <div class="md:mx-20">
        @foreach($alerts as $alert)
            @php
                $badge;
                $border;

                if ($alert->type == 'info') {
                    $badge = 'bg-blue-500';
                    $border = 'border-blue-500';
                }
                if ($alert->type == 'warning') {
                    $badge = 'bg-yellow-500';
                    $border = 'border-yellow-500';
                }
                if ($alert->type == 'update') {
                    $badge = 'bg-green-500 text-white';
                    $border = 'border-green-500';
                }
                if ($alert->type == 'important') {
                    $badge = 'bg-red-500 text-white';
                    $border = 'border-red-500';
                }
            @endphp
            <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl my-4 border-2 {{ $border }}">
                <div class="card-body">
                    <div class="sm:flex sm:justify-between">
                        <div>
                            <p class="card-title"><i class="{{ $alert->icon }}"></i> {{ $alert->title }}</p>
                            <div class="badge {{ $badge }}">{{ $alert->type }}</div>
                        </div>
                        <div class="flex gap-2">
                            <i class="icon-clock text-xl"></i>
                            {{ $alert->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="divider"></div>

                    {!! $alert->message ? \Illuminate\Support\Str::markdown($alert->message) : "" !!}
                </div>
            </div>
        @endforeach
    </div>

</div>
