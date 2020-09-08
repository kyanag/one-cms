
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>登录</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
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

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-signin .checkbox {
            font-weight: 400;
        }
        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
        }
        .form-signin .input-group-append {
            position: relative;
            box-sizing: border-box;
            height: auto;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[name="username"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            font-size: 16px;
        }
        .form-signin input[name="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            font-size: 16px;
        }
        #captcha-img{

        }
    </style>
</head>
<body>
<div class="container text-center">
    <div class="row">
        <form class="form-signin" method="post" action="{{ route("admin.session.login") }}">
            {!! csrf_field() !!}
            <img class="mb-4" src="{{ asset("images/logo.png") }}" alt="" width="210" height="70">
            <h1 class="h3 mb-3 font-weight-normal">请登录</h1>
            <label for="username" class="sr-only">用户名</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="请输入登录账号">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">

            <div class="form-group">
                <label for="captcha" class="sr-only">验证码</label>
                <div class="input-group">
                    <input type="text" id="captcha" name="captcha" class="form-control w-50" placeholder="验证码" required="required" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><img src="{{ captcha_src() }}" id="captcha-img" alt="点击刷新" title="点击刷新" width="85" height="30"/></span>
                    </div>
                </div>
            </div>
            @component("admin::components.flash")@endcomponent
            <button type="submit" class="btn btn-primary btn-block">登录</button>
            <p class="mt-5 mb-3 text-muted">
                Powered by <a href="https://github.com/kyanag/one-cms">OneCMS</a>
            </p>
        </form>
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