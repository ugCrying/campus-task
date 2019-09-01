<?php
/**
 * Created by PhpStorm.
 * User: pengxiao
 * Date: 2019/3/24
 * Time: 22:00
 */

namespace app\index\controller;
use think\Request;


class Pengxiao
{
    public function index()
    {
        return "yes test123";
    }
    public function haha()
    {
        return "hahahahahah";
    }
    public function say()
    {
        return "hahahahahah";
    }
    public function hello($name ="lasjflasj",$version = "laskjfls" )
    {
//        http://localhost/hello?name=1&version=2sadfsd  路由传参 路由规则?参数1=值&参数2=值
        return "hello ".$name."```` ".$version;
    }
    public function test1(Request $request)
    {
        $data1= $request->post();
        $username = $request->post('username');
        $password =$request->post('password');
        var_dump($data1);

        return $data1;

    }
}