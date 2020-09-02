<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function home(){
        return view("admin::home");
    }

}
