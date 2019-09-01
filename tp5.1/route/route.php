<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//use think\Route;
Route::post("login","index/UserController/login");
Route::post("reg","index/UserController/reg");
Route::post("changePwd","index/UserController/changePwd");
Route::post("userInfo","index/UserController/userInfo");
Route::post("updateUserInfo","index/UserController/updateUserInfo");
//TaskController
Route::post("taskQuery","index/TaskController/taskQuery");
Route::post("leaveMsgQuery","index/TaskController/leaveMsgQuery");
Route::post("leaveMsg","index/TaskController/leaveMsg");
Route::post("assignTask","index/TaskController/assignTask");
Route::post("acceptTask","index/TaskController/acceptTask");
Route::get("queryMyTasks","index/TaskController/queryMyTasks");
Route::post("maintain","index/TaskController/maintain");




















//
Route::post("test1","index/pengxiao/test1");
Route::get("haha","index/Pengxiao/haha");
Route::post("say","index/Pengxiao/say");

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
Route::get("/","index/index/index");
Route::get('hello/:name', 'index/hello');
//
//return [
////    "index" => "index/index/index"
////    "haha" => "index/Pengxiao/haha",
//    "test" => function(){
//    return "this is test xixixi";
//    }
////    路由规则名称 =>模块名 控制器 方法名
//];
Route::get("test",function(){
    return "this is test rule";
});
Route::get("hello","index/Pengxiao/hello");
Route::get("users","index/index/dbTest");