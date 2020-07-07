<nav>
    @foreach($menus as $menu)
    <ul>
        <li>
            <a href="{{ $menu['url'] }}">
                <i class="fa {{ $menu['icon'] ?: "fa-file-text" }}"></i>
                <span>{{ $menu['title'] }}</span>
                @if(isset($menu['children']) && count($menu['children']) > 0)<b><i class="fa fa-plus-square-o"></i></b>@endif
            </a>

            @if(isset($menu['children']))
             <ul>
            @foreach($menu['children'] as $submenu)
                <li>
                    <a href="{{ $submenu['url'] }}">
                        <i class="fa {{ $submenu['icon'] ?: "fa-file-text" }}}"></i>
                        <span>{{ $menu['title'] }}</span>
                        @if(isset($submenu['children']) && count($submenu['children']) > 0)<b><i class="fa fa-plus-square-o"></i></b>@endif
                    </a>
                    @if(isset($submenu['children']))
                    <ul>
                        @foreach($submenu['children'] as $_menu)
                            <li>
                                <a href="{{ $_menu['url'] }}">
                                    <i class="fa {{ $_menu['icon'] ?: "fa-file-text" }}}"></i>
                                    <span>{{ $_menu['title'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endforeach
             </ul>
            @endif
        </li>
    </ul>
    @endforeach
</nav>