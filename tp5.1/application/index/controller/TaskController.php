<?php


namespace app\index\controller;
use think\Request;
use think\Controller;
use think\db;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->request = new Request();
        header("Access-Control-Allow-Origin:*");
    }
//    ------任务列表-----------
    public function taskQuery()
    {
        $db = \db("tasks");
        $tasks = $db->query("select * from tasks where status_code =1 and end_time>now() order by creation_time desc");
        $data = array('errCode'=>0,'result'=>$tasks);
        return json_encode($data);
    }
    public function leaveMsgQuery(Request $request)
    {
        $tid = $request->post('tid');
        $db = \db("leave_msg");
        $leaveMsg = $db->query("select * from leave_msg where tid = '$tid' order by create_time desc ");
        $data = array('errCode'=>0,'result'=>$leaveMsg);
        return json_encode($data);
    }
    public function leaveMsg(Request $request)
    {

        $username = $request->post('username');
        $msgDetail = $request->post('msgDetail');
        $create_time =$request->post('createTime');
        $writer_nickname = $request->post('nickname');
        $tid = $request->post('tid');
//        echo $writer_nickname;
        $db = \db("leave_msg");
        $res = $db->execute("insert into leave_msg(tid,msgDetail,create_time,writer_username,writer_nickname) values('$tid','$msgDetail','$create_time','$username','$writer_nickname')");
        $data = array('errCode'=>0,'result'=>$res);
        return json_encode($data);
    }
    public function assignTask(Request $request)
    {
        $username = $request->post('username');
        $tname = $request->post('tname');
        $creation_time=$request->post('createTime');
        $end_time=$request->post('endTime');
        $details =$request->post('taskDetail');
        $status = "waiting";
        $bonus =$request->post('bonus');
        $c_nickname =$request->post('nickname');
        $db = \db("tasks");
        $res = $db->execute("insert into tasks(client,tname,creation_time,end_time,details,task_status,bonus,c_nickname,status_code) values('$username','$tname','$creation_time','$end_time','$details','$status','$bonus','$c_nickname',1)");
        $data = array('errCode'=>0,'result'=>$res);
        return json_encode($data);
    }
    public function acceptTask(Request $request)
    {
        $username = $request->post('username');
        $b_nickname =$request->post('nickname');
        $tid =$request->post('tid');
        $db = \db("tasks");
        $res = $db->execute("update tasks set bailee ='$username' ,b_nickname='$b_nickname',task_status='waitGoing',status_code=status_code +1 where tid = '$tid'");
        $data = array('errCode'=>0,'result'=>$res);
        return json_encode($data);

    }
    public function queryMyTasks(Request $request)
    {
        $username = $request->get('username');
        $db = \db("tasks");
        $res = $db->query("select * from tasks where client = '$username' and status_code>0  or bailee = '$username' and status_code > 0");
        $data = array('errCode'=>0,'result'=>$res);
        return json_encode($data);
    }
    public function maintain(Request $request)
    {
        $tid = $request->post('tid');
        $condition = $request->post("condition");
        if($condition){
            $db = \db("tasks");
            $res = $db->execute("update tasks set status_code=-1 where tid = '$tid'");
            $data = array('errCode'=>0,'result'=>$res);
            return json_encode($data);
        }
        $db = \db("tasks");
        $res = $db->execute("update tasks set status_code=status_code +1 where tid = '$tid'");
        $data = array('errCode'=>0,'result'=>$res);
        return json_encode($data);
    }
}
