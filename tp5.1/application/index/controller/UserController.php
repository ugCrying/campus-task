<?php
/**
 * Created by PhpStorm.
 * User: pengxiao
 * Date: 2019/4/8
 * Time: 20:50
 */

namespace app\index\controller;
use think\Request;
use think\Controller;
use think\db;
class UserController extends Controller
{
    public function __construct()
    {
        $this->request = new Request();
        header("Access-Control-Allow-Origin:*");
    }
    //-----------------------------登陆--------------------------
    public function login(Request $request)
    {
        $username = $request->post('username');
        $password =$request->post('password');
        //连接一次数据库执行多次操作
        $db = \db("users");
        $user = $db->query("select * from users where username = '$username'");
        if(count($user) < 1){
            global $errCode,$errMsg;
            $errMsg = "用户不存在";
            $errCode = 1;
        }else{
            if($password !== $user[0]['userpwd']){
                global $errCode,$errMsg;
                $user = null;
                $errMsg = "密码错误";
                $errCode = 2;
            }else{
                global $errCode,$errMsg;
//                $user = null;
                $errMsg = "登陆成功";
                $errCode = 0;
            }
        }
        $data = array('errCode'=>$errCode,'errMsg'=>$errMsg,'result'=>$user);
        return json_encode($data);
    }
    //-----------------------------注册--------------------------
    public function reg(Request $request){
        $username = $request->post('regName');
        $password =$request->post('regPwd');
        $db = \db("users");
        $user = $db->query("select * from users where username = '$username'");
        if(count($user) >= 1){
            $errCode = 1;
            $errMsg = "用户名已存在，请重新设置";
        }else{

            $res = $db->execute("insert into users(username,userpwd) values('$username','$password')");
            if($res == 1){
                $errCode = 0;
                $errMsg = "注册成功！";
            }
        }
        $data = array('errCode'=>$errCode,'errMsg'=>$errMsg);
        return json_encode($data);
    }
    //-----------------------------修改密码--------------------------
    public function changePwd(Request $request)
    {
        $username = $request->post('username');
        $oldPwd = $request->post('oldPwd');
        $newPwd =$request->post('newPwd');
        $db = \db("users");
        $user = $db->query("select * from users where username = '$username'");

        if($user[0]['userpwd'] !== $oldPwd){
            global $errCode,$errMsg;
            $errMsg = "旧密码输入错误，请重新输入";
            $errCode = 1;
        }else{
            global $errCode,$errMsg;
            $res = $db->execute("update users set userpwd = '$newPwd' where username = '$username'");
//            var_dump($res);
            if($res == 1){
                $errMsg = "修改成功！";
                $errCode = 0;
            }else{
                $errMsg = "服务器错误！";
                $errCode = 2;
            }
        }
        $data = array('errCode'=>$errCode,'errMsg'=>$errMsg);
        return json_encode($data);
    }
    public function userInfo(Request $request)
    {
        $username = $request->post('username');
        $db = \db("users");
        $user = $db->query("select * from users where username = '$username'");
        $data = array('result'=>$user);
        return json_encode($data);
    }
    public function updateUserInfo(Request $request)
    {
        $username = $request->post('username');
        $nickname = $request->post('nickname');
        $birthday= $request->post('birthday');
        $gender= $request->post('gender');
        $studentNumber= $request->post('studentNumber');
        $class= $request->post('class');
        $dormitary= $request->post('dormitary');
        $realname= $request->post('realname');
        $IDnumber= $request->post('IDnumber');
        $cellphoneNumber= $request->post('cellphoneNumber');
        $db = \db("users");
        $res = $db->execute("update users set nickname='$nickname',gender='$gender',studentNumber='$studentNumber',birthday='$birthday',class='$class',dormitary='$dormitary',realname='$realname',IDnumber='$IDnumber',cellphone='$cellphoneNumber' where username = '$username'");
        $data = array('result'=>$res,'errCode'=>0);
        return json_encode($data);
    }
}