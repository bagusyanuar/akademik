<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <span>{{ $title }}</span> {{ isset($header_action) ? $header_action : '' }}
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    @if($footer)
        <div class="card-footer">
            {{ isset($footer_slot) ? $footer_slot : '' }}
        </div>
    @endif
</div>
