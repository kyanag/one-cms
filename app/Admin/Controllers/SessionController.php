<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{

    /**
     * 登录入口
     * @return \Illuminate\Http\Response
     */
    public function loginEntry(Request $request)
    {
        return view("admin::login");
    }

    /**
     * 登录操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if(auth("admin")->attempt($credentials)){
            Log::debug("session {$request->route()->getName()}", $request->session()->all());
            return redirect(route("admin.home"));
        }else{
            flash("账号或者密码错误!", "warning");
            return back();
        }
    }

    /**
     * 登出
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|array
     */
    public function logout()
    {
        \auth("admin")->logout();
        return [
            'msg' => "退出成功",
            'jump' => route("admin.session.loginEntry")
        ];
    }
}
