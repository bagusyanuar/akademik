<aside {{ $attributes->merge(['class' => 'main-sidebar']) }}>
    {{ isset($brand) ? $brand : ''}}
    <div class="sidebar">
        {{ isset($profiles) ? $profiles : ''}}
        @if(isset($menu))
            <div class="my-sidebar-menu">
                <ul class="nav nav-sidebar nav-pills flex-column">
                    {{ $menu }}
                </ul>
            </div>
        @endif
        {{ isset($footer) ? $footer : ''}}
    </div>
</aside>
