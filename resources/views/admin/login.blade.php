<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>工作台</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="{{ asset("css/vendor/bootstrap/dist/bootstrap.css") }}">
    <link rel="stylesheet" href="{{ asset("css/vendor/Animate.css") }}">
    <link rel="stylesheet" href="{{ asset("css/basic.css") }}">
    <link rel="stylesheet" href="{{ asset("css/vendor/font_awesome/css/font-awesome.css") }}">
</head>

<body>
<div class="container">
    <form class="form-signin" method="post" action="{{ route("admin.session.store") }}">
        <div class="logo"><img src="{{ asset("images/logo.png") }}" style="height: 50px;width: 150px" alt="OneCms" title="OneCms@kyanag"/></div>
        <h3>欢迎使用 OneCms </h3>
        <div class="form-group">
            <label for="username">用户名</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="用户名" required="required" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">密码</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="密码" required="required" autocomplete="off">
        </div>
        <div class="form-group" style="position:relative;">
            <label for="captcha">验证码</label>
            <div class="input-group">
                <input type="text" id="captcha" name="captcha" class="form-control" placeholder="验证码" required="required" autocomplete="off">
                <div class="input-group-addon">
                    <img src="{{ captcha_src() }}" id="captcha_img"/>
                </div>
            </div>
        </div>
        <button class="btn btn-lg btn-primary btn-block subBtn" type="submit">登录</button>
        <div class="copyright"><i class="fa fa-copyright"></i><a href="https://github.com/kyanag">kyanag</a></div>
    </form>
</div>

<script src="{{ asset("js/vendor/jquery.min.js") }}"></script>
<script src="{{ asset("js/vendor/bootstrap/dist/bootstrap.js") }}"></script>
<script src="{{ asset("js/vendor/ie10-viewport-bug-workaround.js") }}"></script>
<script>
    $(function(){
        var i = 0;
        var src = "{{ captcha_src() }}";
        $("#captcha_img").click(function(){
            i++;
            $(this).attr("src", `${src}_${i}`);
        });
    })
</script>
</body>
</html>