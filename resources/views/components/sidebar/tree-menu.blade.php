<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $title }}
            <i class="right fa fa-angle-down"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach($children as $child)
        <li class="nav-item">
            <a href="{{ $child['link'] }}" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>{{ $child['title'] }}</p>
            </a>
        </li>
        @endforeach
    </ul>
</li>
