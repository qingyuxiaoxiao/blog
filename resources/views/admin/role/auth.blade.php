<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
@include('admin.public.styles')
@include('admin.public.script')
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form" action="{{ url('admin/role') }}" method="post">
        {{ csrf_field() }}
        <div class="layui-form-item">
            <label for="role_name" class="layui-form-label">
                <span class="x-red">*</span>角色名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="role_name" name="role_name" required="" lay-verify=""
                       autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>权限列表
            </label>
            <div class="layui-input-inline" style="width:600px;">
                @foreach($perms as $v)
                    @if(in_array($v->id,$own_pers))
                        <input type="checkbox" checked name="permission_id[]" title="{{ $v->per_name }}"
                               value="{{ $v->id }}" lay-skin="primary">
                    @else
                        <input type="checkbox" name="permission_id[]" title="{{ $v->per_name }}" value="{{ $v->id }}"
                               lay-skin="primary">

                    @endif


                @endforeach
            </div>

        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button class="layui-btn" lay-filter="add" lay-submit="">
                增加
            </button>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'layer'], function () {
        $ = layui.jquery;
        var form = layui.form
            , layer = layui.layer;


        //监听提交
        form.on('submit(add)', function (data) {
            //发异步，把数据提交给php

            // return false;
        });
    });
</script>

</body>

</html>