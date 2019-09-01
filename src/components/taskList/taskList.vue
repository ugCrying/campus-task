<template>
  <div id="taskPage">
    <el-card class="box-card" v-for="item in taskData">
      <div slot="header" class="clearfix">
        <span v-for="(msg,key) in item" :key="msg" v-if="key == 'tname'">{{msg}}</span>
        <el-button style="float: right; padding: 3px 0" type="text" @click="accept(item)">接受</el-button>
      </div>
      <div
        v-for="(msg,key) in item"
        :key="msg"
        class="text item"
        v-if="key !== 'id'&&key!=='clientId'&&key!=='baileeId'&&key!=='tname'&&key!=='tid'"
      >{{key +":"+ msg }}</div>
      <el-button
        style="float: right; margin-bottom:10px; padding: 3px 0"
        type="text"
        @click="leaveMsgOpen(item)"
      >留言</el-button>
    </el-card>
    <el-dialog title="留言板" :visible.sync="dialogVisible" width="50%" :before-close="handleClose">
      <el-table :data="tableData" height="250" style="width: 100%">
        <el-table-column prop="date" label="时间" width="100"></el-table-column>
        <el-table-column prop="name" label="昵称" width="100"></el-table-column>
        <el-table-column prop="address" label="内容"></el-table-column>
      </el-table>
      <span slot="footer" class="dialog-footer">
        <el-input
          v-model="leaveMsgDetail"
          style="display:inline-block;width:70%;"
          placeholder="请输入留言内容"
        ></el-input>
        <el-button type="primary" @click="leaveMsg">发送</el-button>
        <el-button @click="dialogVisible = false">关 闭</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
import Axios from "axios";
import qs from "qs";
export default {
  data() {
    return {
      dialogVisible: false,
      username: "",
      leaveMsgDetail: "",
      tempTid: "",
      tableData: [],
      taskData: [],
      tableData1: [
        {
          date: "2016-05-03 10:22:37",
          name: "王小虎",
          address: "佣金太少啦！"
        },
        {
          date: "2016-05-02 17:26:06",
          name: "李四",
          address: "请问明天早上帮你完成可以吗？"
        }
      ]
    };
  },
  methods: {
    leaveMsgOpen(param) {
      this.dialogVisible = true;
      if (param !== "again") this.tempTid = param.tid;
      let params = qs.stringify({
        tid: this.tempTid
      });
      Axios.post("/leaveMsgQuery", params)
        .then(res => {
          console.log(res);
          let newData = [];
          res.data.result.forEach((item, index) => {
            newData.push({
              id: index + 1,
              date: item.create_time,
              name: item.writer_nickname == "" ? "匿名" : item.writer_nickname,
              address: item.msgDetail
            });
          });
          this.tableData = newData;
        })
        .catch(err => {
          alert(err);
        });
    },
    leaveMsg() {
      let myDate = new Date();
      let time =
        myDate.getFullYear() +
        "-" +
        (myDate.getMonth() + 1) +
        "-" +
        myDate.getDate() +
        " " +
        myDate.getHours() +
        ":" +
        myDate.getMinutes() +
        ":" +
        myDate.getSeconds();
      let params = qs.stringify({
        username: this.username,
        nickname: this.$getCookie("nickname"),
        tid: this.tempTid,
        createTime: time,
        msgDetail: this.leaveMsgDetail
      });
      Axios.post("/leaveMsg", params)
        .then(res => {
          console.log(res);
          if (res.data.errCode == 0) {
            this.leaveMsgDetail = "";
            this.leaveMsgOpen("again");
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    handleClose(done) {
      done();
    },
    accept(val) {
      console.log(val.tid);
      this.$confirm("确定要领取该任务吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.handleAccept(val.tid);
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消"
          });
        });
    },
    handleAccept(tid) {
      let params = qs.stringify({
        username: this.$getCookie("username"),
        nickname: this.$getCookie("nickname"),
        tid: tid
      });
      let self = this;
      Axios.post("acceptTask", params)
        .then(res => {
          console.log(res);
          if (res.data.errCode == 0) {
            this.$message({
              type: "success",
              message: "领取成功!"
            });
            self.taskQuery();
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    taskQuery() {
      Axios.post("/taskQuery")
        .then(res => {
          console.log(res);
          let newData = [];
          res.data.result.forEach((item, index) => {
            newData.push({
              tname: item.tname,
              id: index + 1,
              tid: item.tid,
              发布者: item.c_nickname,
              发布时间: item.creation_time,
              截止时间: item.end_time,
              任务内容: item.details,
              奖励: "￥" + item.bonus
            });
          });
          this.taskData = newData;
        })
        .catch(err => {
          alert(err);
        });
    }
  },
  mounted() {
    if (this.$getCookie("username"))
      this.username = this.$getCookie("username");
    this.taskQuery();
  }
};
</script>
<style>
.text {
  font-size: 14px;
}

.item {
  margin-bottom: 18px;
}

.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}
.clearfix:after {
  clear: both;
}
#taskPage .el-input__inner {
  /* text-align: center; */
  height: 40px;
}
.box-card {
  max-width: 480px;
  margin: 20px auto 20px;
}
</style>
