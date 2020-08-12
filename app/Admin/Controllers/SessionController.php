<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{

    /**
     * 登录入口
     * @return \Illuminate\Http\Response
     */
    public function loginEntry()
    {
        flash("这是一个测试");

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
        return 1;
    }

    /**
     * 登出
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        //
    }
}
