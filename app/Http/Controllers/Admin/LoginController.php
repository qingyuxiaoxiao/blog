<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Org\code\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;


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
    public function doLogin(Request $request)
    {
        $input = $request->except('_token');
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];

        $msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数组字母下滑线',
        ];

        $validator = Validator::make($input,$rule,$msg);
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
        //验证验证码
        if(strtolower($input['code']) != strtolower(session()->get('code')) ){
            return redirect('admin/login')->with('errors','验证码错误');
        }

        //查询数据库
        $user =  User::where('user_name',$input['username'])->first();
        //查询用户是否存在
        if(!$user){
            return redirect('admin/login')->with('errors','用户名错误');
        }
        //验证密码是否正确
        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码错误');
        }
        //将信息保存在session中
        session()->put('user',$user);

        //跳转到后台首页
        return redirect('admin/index');

    }



    //后台首页
    public function index()
    {
        return view('admin.index');
    }

    //后台欢迎页
    public function welcome()
    {
        return view('admin.welcome');
    }

    //退出登录
    public function logout()
    {
        // 清空session中的用户信息
        session()->flush();
        // 跳转到登录页面
        return redirect('admin/login');
    }
    //没有权限，对应的跳转
    public function noaccess()
    {
        return view('errors.noaccess');
    }

    public function jiami()
    {
        $str = '123456';
//        $crypt_str = 'eyJpdiI6IjJwQ3BOekg1eFpBQ1VHd2RXcno1aUE9PSIsInZhbHVlIjoiT2hwTEJRVmlubVY2dlBVYWp2aWlrQT09IiwibWFjIjoiYTc0MzVhNmQ0ZTFiMzE2NDBiNWI5NTliODE4ZDc1ZWFiNTE4N2FkMTdkN2QxZTJjOGE5MTFlNWVmMzFmMzM1OCJ9';
        $crypt_str = Crypt::encrypt($str);
        return $crypt_str;
    }
}
