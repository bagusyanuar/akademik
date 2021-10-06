<ol class="breadcrumb breadcrumb-transparent mb-0">
    @foreach($item as $key => $i)
        @if(next($item) !== false)
            <li class="breadcrumb-item">
                <a href="{{$i['link']}}">{{ $i['title'] }}</a>
            </li>
        @else
            <li class="breadcrumb-item active" aria-current="page">{{ $i['title'] }}
            </li>
        @endif
    @endforeach
</ol>
