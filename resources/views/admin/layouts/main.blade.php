
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="kyanag">
    <title>@yield('title', "工作台")</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
    <meta name="theme-color" content="#563d7c">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="{{ asset("css/dashboard.css") }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3 text-center" href="{{ route("admin.home") }}">OneCMS</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link J_confirm_modal" href="{{ route("admin.session.logout") }}" data-tip="确认退出!" data-type="post">退出</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            {!! app("nav")->render() !!}
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            @yield("main")
        </main>
    </div>
</div>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.bundle.js"></script>
<script src="https://cdn.bootcss.com/bootbox.js/5.4.0/bootbox.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/wangEditor/10.0.13/wangEditor.js"></script>
<script src="{{ asset("js/basic.js") }}?{{ time() }}"></script>
<script>
    @foreach(\App\Supports\Asset::$js as $js)
        {!! $js !!}
    @endforeach

    $(function(){
        //图标
    });
</script>

</body>
</html>
