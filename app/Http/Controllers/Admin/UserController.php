<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * 用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::orderBy('user_id','asc')
            ->where(function ($quest) use($request){
                $username = $request->input('username');
                $email    = $request->input('email');
                if (!empty($username)){
                    $query->where('user_name','like','%'.$username.'%');
                }
                if(!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })
            ->paginate($request->input('num')?$request->input('num'):3);

        return view('admin.user.list',compact('user','request'));
    }

    /**
     * 用户添加页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.user.add');
    }

    /**
     * 执行添加用户
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return 1111;
        //接收前台表单提交数据
        $input = $request->all();

        //添加数据到数据库

        $pass = Crypt::encrypt($input['pass']);
        $res  = User::create(['user_name'=>$input['user_name'],'phone'=>$input['phone'],'user_pass'=>$pass,'email'=>$input['email']]);
        //判断是否添加成功
        if ($res){
            $data = [
                'status'  => 0,
                'message' => '添加用户成功'
            ];
        }else{
            $data = [
                'status'  => 1,
                'message' => '添加用户失败'
            ];
        }
        return $data;
    }

    /**
     * 显示一条数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * 更新数据
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //使用id 查询数据

        $input = $request->all();
        $user = User::find($id);
        $res = $user->update($input);
        /*$username = $request->input('user_name');
        $user->user_name = $username;
        $res = $user->save();*/
        if ($res){
            $data = [
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
        return $data;
    }

    /**
     * 删除操作
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $res = $user->delete();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
        return $data;
    }
    //删除选中用户
    public function delAll(Request $request)
    {
        $input = $request->input('ids');
        $res   = User::destroy($input);
        if ($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;

    }
}
