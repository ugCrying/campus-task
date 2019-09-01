<?php
namespace app\index\controller;
use think\Db;
class Index
{
    public function index()
    {   echo "这是index";
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) 2018新年快乐</h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function dbTest()
    {
        $username = "zhangsan";
        $test = Db::query("select * from users where username ='$username'");
//        $test2 = Db::name('users')->where('username')
//        var_dump($test);
//        return $test[0]['username'];
//        echo $test[0]['username'];
        //======================================================================
//        //使用db添加数据
//        $res = Db::execute("insert into users(username,gender) values('xiaohong',20)");
//        var_dump($res);
//        //使用Db修改数据
//        $res2 = Db::execute("update users set gender=15 where username = 'xiaohong'");
//        var_dump($res2);
//        //查询
//        $res3 = Db::query("select * from users");
//        var_dump($res3);
//        //删除
//        $res4 = Db::execute("delete from users where username ='lisi'");
//          //连接一次数据库执行多次操作
//        $db = \db("users");//返回对象
//        $res = $db->execute("insert into users(realname,rank) values('hahah',12)");
//        dump($res);

    }
}
