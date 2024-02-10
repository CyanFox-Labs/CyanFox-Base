<div>
    @forelse (app('integrate.views')->getAll() as $moduleComponent)
        @if($moduleComponent['section'] == 'home')
            @component($moduleComponent['component'])
            @endcomponent
        @endif
    @empty
    @endforelse
</div>
