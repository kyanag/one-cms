
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <!-- Generated: 2019-04-04 16:55:45 +0200 -->
    <title>登录</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <link href="https://preview.tabler.io/assets/css/dashboard.css" rel="stylesheet" />
    <style>
        #captcha-img{
            height: 100%;
            border: 1px solid rgba(0, 40, 100, 0.12);
        }
    </style>
</head>
<body class="">
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">
                    <div class="text-center mb-2">
                        <img src="{{ asset("images/logo-for-tabler.png") }}" class="h-7" alt="">
                    </div>
                    <form class="card" method="post" action="{{ route("admin.session.login") }}">
                        <div class="card-body p-6">
                            <div class="card-title">欢迎使用 OneCMS </div>
                            <div class="form-group">
                                <label class="form-label" for="username">账号</label>
                                <input type="email" id="username" name="username" class="form-control" placeholder="请输入登录账号">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">
                                    密码
{{--                                    <a href="./forgot-password.html" class="float-right small">I forgot password</a>--}}
                                </label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
                            </div>
                            <div class="form-group" style="position:relative;">
                                <label for="captcha" class="form-label">验证码</label>
                                <div class="input-group">
                                    <input type="text" id="captcha" name="captcha" class="form-control" placeholder="验证码" required="required" autocomplete="off">
                                    <div class="input-group-addon">
                                        <img src="{{ captcha_src() }}" id="captcha-img" alt="点击刷新" title="点击刷新"/>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label class="custom-control custom-checkbox">--}}
{{--                                    <input type="checkbox" class="custom-control-input" />--}}
{{--                                    <span class="custom-control-label">Remember me</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">登录</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center text-muted">
                        Powered by <a href="https://github.com/kyanag/one-cms">OneCMS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.staticfile.org/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function(){
        var i = 0;
        var src = "{{ captcha_src() }}";
        $("#captcha-img").click(function(){
            i++;
            $(this).attr("src", `${src}_${i}`);
        });
    })
</script>
</body>
</html>

{{--<!DOCTYPE html>--}}
{{--<html lang="">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>--}}
{{--    <title>工作台</title>--}}
{{--    <meta name="description" content="">--}}
{{--    <meta name="author" content="">--}}
{{--    <link rel="stylesheet" href="{{ asset("css/vendor/bootstrap/dist/bootstrap.css") }}">--}}
{{--    <link rel="stylesheet" href="{{ asset("css/vendor/Animate.css") }}">--}}
{{--    <link rel="stylesheet" href="{{ asset("css/basic.css") }}">--}}
{{--    <link rel="stylesheet" href="{{ asset("css/vendor/font_awesome/css/font-awesome.css") }}">--}}
{{--</head>--}}

{{--<body>--}}
{{--<div class="container">--}}
{{--    <form class="form-signin" method="post" action="{{ route("admin.session.store") }}">--}}
{{--        <div class="logo"><img src="{{ asset("images/logo.png") }}" style="height: 50px;width: 150px" alt="OneCms" title="OneCms@kyanag"/></div>--}}
{{--        <h3>欢迎使用 OneCms </h3>--}}
{{--        <div class="form-group">--}}
{{--            <label for="username">用户名</label>--}}
{{--            <input type="text" id="username" name="username" class="form-control" placeholder="" required="required" autocomplete="off">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="password">密码</label>--}}
{{--            <input type="password" id="password" name="password" class="form-control" placeholder="密码" required="required" autocomplete="off">--}}
{{--        </div>--}}
{{--        <div class="form-group" style="position:relative;">--}}
{{--            <label for="captcha">验证码</label>--}}
{{--            <div class="input-group">--}}
{{--                <input type="text" id="captcha" name="captcha" class="form-control" placeholder="验证码" required="required" autocomplete="off">--}}
{{--                <div class="input-group-addon">--}}
{{--                    <img src="{{ captcha_src() }}" id="captcha_img"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <button class="btn btn-lg btn-primary btn-block subBtn" type="submit">登录</button>--}}
{{--        <div class="copyright"><i class="fa fa-copyright"></i><a href="https://github.com/kyanag">kyanag</a></div>--}}
{{--    </form>--}}
{{--</div>--}}

{{--<script src="{{ asset("js/vendor/jquery.min.js") }}"></script>--}}
{{--<script src="{{ asset("js/vendor/bootstrap/dist/bootstrap.js") }}"></script>--}}
{{--<script src="{{ asset("js/vendor/ie10-viewport-bug-workaround.js") }}"></script>--}}
{{--<script>--}}
{{--    $(function(){--}}
{{--        var i = 0;--}}
{{--        var src = "{{ captcha_src() }}";--}}
{{--        $("#captcha_img").click(function(){--}}
{{--            i++;--}}
{{--            $(this).attr("src", `${src}_${i}`);--}}
{{--        });--}}
{{--    })--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}