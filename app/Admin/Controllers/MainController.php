<?php

namespace App\Admin\Controllers;

use App\Components\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function home(){
        return view("admin::home");
    }

}
