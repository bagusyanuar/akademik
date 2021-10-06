<ul class="navbar-nav">
    @if($isPushMenu)
        <li class="nav-item">
            <a class="nav-link navbar-link-item" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
    @endif
    {{ $slot }}
</ul>
