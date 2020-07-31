<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>@yield('title', "工作台")</title>
    <meta name="description" content="@yield('description', "")">
    <meta name="author" content="kyanag">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("css/basic.css") }}">

    <link href="https://cdn.bootcdn.net/ajax/libs/wangEditor/10.0.13/wangEditor.css" rel="stylesheet">
</head>

<body>
<header id="header">
    <div class="logo"><a href="{{ route("admin.home") }}"><img src="{{ asset("images/logo.png") }}" alt="OneCms" width="120" height=""></a></div>
    <div class="right_side">
        <!--<span class="fullScreen_btn"><i class="fa fa-arrows-alt"></i></span>-->
        <span data-target="../server/logout.json" data-tip="确认退出吗？"><i class="fa fa-sign-out"></i></span>
        <span class="toggleMenu_btn"><i class="fa fa-bars"></i></span>
    </div>
</header>
<aside id="left" class="animated">
    <div id="userinfo">
        <div>
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-user"></i><span class="name">admin</span><span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#">个人资料</a></li>
                <li><a href="#" class="J_confirm_modal" data-target="../server/logout.json" data-tip="确认退出吗？">退出</a></li>
            </ul>
        </div>
    </div>
    {!! app("nav")->render() !!}
    <span class="minifyBtn"><i class="fa fa-arrow-circle-left"></i></span>
</aside>
@yield("main")
<footer id="footer">
    <div class="inside"><i class="fa fa-copyright"></i><a href="https://github.com/liyu365">liyu</a></div>
</footer>

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/bootbox.js/5.4.0/bootbox.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="https://cdn.bootcdn.net/ajax/libs/wangEditor/10.0.13/wangEditor.js"></script>
<script src="{{ asset("js/basic.js") }}?{{ time() }}"></script>
<script>
@foreach(\App\Supports\Asset::$js as $js)
{!! $js !!}
@endforeach
</script>
</body>
</html>