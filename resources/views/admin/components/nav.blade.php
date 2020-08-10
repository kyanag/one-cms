<div class="sidebar-sticky pt-3">
    <ul class="nav flex-column">
        @foreach($menus as $menu)
        <li class="nav-item">
            @if(!isset($menu['children']))
                <a class="nav-link" href="{{ $menu['url'] }}"><i class="fa {{ $menu['icon'] ?: "fa-file-text" }}"></i><span>{{ $menu['title'] }}</span></a>
            @else
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{ $menu['title'] }}</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    @foreach($menu['children'] as $submenu)
                        <li class="nav-item">
                            @if(!isset($submenu['children']))
                                <a class="nav-link" href="{{ $submenu['url'] }}"><i class="fa {{ $submenu['icon'] ?: "fa-file-text" }}"></i><span>{{ $submenu['title'] }}</span></a>
                            @else
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>{{ $submenu['title'] }}</span>
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