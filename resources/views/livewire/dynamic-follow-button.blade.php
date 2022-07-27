<div id="follow-button-{{$containerId}}">
    @if(!Auth::guard('web')->guest())
    @if(Auth::guard('web')->user()->follows->where('target_type', $targetType)->where('target_id', $targetId)->isEmpty())
    <livewire:follow-button :target_type="$targetType" :target_slug="$targetSlug">
    @else
    <livewire:unfollow-button :target_type="$targetType" :target_slug="$targetSlug">
    @endif
    @else
    <button>
        <button class="follow-button">Entrar para seguir</button>
    </button>
    @endif
</div>