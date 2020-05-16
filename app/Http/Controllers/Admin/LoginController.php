<?php

namespace App\Http\Controllers\Admin;

use App\Org\code\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //后台登录
    public function login()
    {
        return view('admin.login');
    }
    //验证码
    public function code()
    {
        $code = new Code();
        return $code->make();
    }
}
