<div class="pt-3">
    <ul class="nav flex-column">
        @foreach($navs as $nav)
        <li class="nav-item">
            @if(!isset($nav['children']))
                <a class="nav-link" href="{{ $nav['url'] }}"><i class="fa {{ $nav['icon'] ?: "fa-file-text" }}"></i> <span>{{ $nav['title'] }}</span></a>
            @else
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{ $nav['title'] }}</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    @foreach($nav['children'] as $subnav)
                        <li class="nav-item">
                            @if(!isset($subnav['children']))
                                <a class="nav-link" href="{{ $subnav['url'] }}"><i class="fa {{ $subnav['icon'] ?: "fa-file-text" }}"></i> <span>{{ $subnav['title'] }}</span></a>
                            @else
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>{{ $subnav['title'] }}</span>
                                </h6>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
        @endforeach
    </ul>
</div>