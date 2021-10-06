<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $title }}
            <i class="right fa fa-angle-down"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{ $slot }}
    </ul>
</li>
