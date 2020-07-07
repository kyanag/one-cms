<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>@yield('title', "工作台")</title>
    <meta name="description" content="@yield('description', "")">
    <meta name="author" content="kyanag">
    <link rel="stylesheet" href="{{ asset("css/vendor/bootstrap/dist/bootstrap.css") }}">
    <link rel="stylesheet" href="{{ asset("css/vendor/Animate.css") }}">
    <link rel="stylesheet" href="{{ asset("css/basic.css") }}">
    <link rel="stylesheet" href="{{ asset("css/vendor/font_awesome/css/font-awesome.css") }}">

    <script src="{{ asset("js/vendor/html5shiv.min.js") }}"></script>
    <script src="{{ asset("js/vendor/respond.min.js") }}"></script>
</head>

<body>
<div id="iframe_main">
    @component("admin::components.flash")@endcomponent

    @yield("content")
</div>
<script src="{{ asset("js/vendor/jquery.min.js") }}"></script>
<script src="{{ asset("js/vendor/bootstrap/dist/bootstrap.js") }}"></script>
<script src="{{ asset("js/vendor/catpl.js") }}"></script>
<script src="{{ asset("js/vendor/ie10-viewport-bug-workaround.js") }}"></script>
<script src="{{ asset("js/ajaxForm.js") }}"></script>
<script src="{{ asset("js/basic.js") }}"></script>
</body>
</html>