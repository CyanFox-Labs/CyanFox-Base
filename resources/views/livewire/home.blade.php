<div>
    @forelse (app('integrate.views')->getAll() as $moduleComponent)
        @if($moduleComponent['section'] == 'home' && $moduleComponent['location'] == 'home')
            @component($moduleComponent['component'])
            @endcomponent
        @endif
    @empty
    @endforelse
</div>
