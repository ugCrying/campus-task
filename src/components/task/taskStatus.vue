<template>
  <div class="taskStatus" style="min-height:500px">
    <!-- <h1 >任务管理</h1> -->
    <!-- <div> -->
    <div class="tips">
      <div class="tip1">待接受</div>
      <div class="tip4">待执行</div>
      <div class="tip2">执行中</div>
      <div class="tip3">已完成</div>
    </div>
    <!-- </div> -->
    <el-table
      @cell-click="itemClick"
      :data="tableData"
      style="width: 90%;margin: 100px auto"
      :row-class-name="tableRowClassName"
    >
      <el-table-column align="center" prop label="操作" width="60">
        <i class="el-icon-edit" style="cursor:pointer"></i>
      </el-table-column>
      <el-table-column prop="status" label="状态" width="80"></el-table-column>
      <el-table-column prop="tid" label="任务编号" width="80"></el-table-column>
      <el-table-column prop="taskName" label="任务名称" width="80"></el-table-column>
      <el-table-column prop="endTime" label="截止时间" width="180"></el-table-column>
      <el-table-column prop="detail" label="内容"></el-table-column>
    </el-table>
    <el-dialog
      title="任务状态维护"
      :visible.sync="dialogVisible"
      width="50%"
      :before-close="handleClose"
      :before-open="beforeOpen"
    >
      <el-steps :active="active" finish-status="success">
        <el-step title="待接受"></el-step>
        <el-step title="待执行"></el-step>
        <el-step title="执行中"></el-step>
        <el-step title="任务完成"></el-step>
      </el-steps>

      <el-button style="margin-top: 12px;" @click="next">{{editStatusText}}</el-button>
      <el-button style="margin-top: 12px;" @click="apprise" v-if="isShow">评价</el-button>
      <el-button style="margin-top: 12px;float:right;witdh:80px" @click="complete">放弃/终止</el-button>
    </el-dialog>
    <el-dialog :visible.sync="appriseDisabled">
      <div class="block">
        <span class="demonstration">请打分</span>
        <el-rate v-model="value1"></el-rate>
      </div>输入评价内容：
      <el-input v-model="appDetail"></el-input>
      <el-button type="primary" @click="closeApp">提交</el-button>
    </el-dialog>
    <user-controller ref="userController"></user-controller>
  </div>
</template>


<script>
import qs from "qs";
import Axios from "axios";
export default {
  data() {
    return {
      tableData: [],
      dialogVisible: false,
      active: 0,
      editStatusText: "",
      tempTid: "",
      isShow: false,
      value1: null,
      appriseDisabled: false,
      appDetail: ""
    };
  },
  methods: {
    apprise() {
      this.appriseDisabled = true;
    },
    closeApp() {
      this.appriseDisabled = false;
    },
    next() {
      this.active++;
      if (this.active > 4) {
        this.dialogVisible = false;
        this.tempTid = "";
        this.editStatusText = "";
        this.queryMyTasks();
      } else {
        if (this.active == 4) {
          this.editStatusText = "关闭";
          // return false;
          this.isShow = true;
        }
        let params = qs.stringify({
          tid: this.tempTid
        });
        Axios.post("/maintain", params)
          .then(res => {
            console.log(res);
          })
          .catch(err => {
            alert(err);
          });
      }
    },
    tableRowClassName({ row, rowIndex }) {
      if (row.status === "执行中") {
        return "warning-row";
      } else if (row.status === "已完成") {
        return "success-row";
      } else if (row.status === "待执行") {
        return "waitGoing";
      }
      return "";
    },
    queryMyTasks() {
      let params = qs.stringify({
        username: this.$getCookie("username")
      });
      Axios.get("/queryMyTasks?" + params)
        .then(res => {
          console.log(res);
          if (res.data.errCode == 0) {
            let newData = [];
            res.data.result.forEach((item, index) => {
              let status;
              if (item.status_code == 1) {
                status = "待接受";
              } else if (item.status_code == 2) {
                status = "待执行";
              } else if (item.status_code == 3) {
                status = "执行中";
              } else {
                status = "已完成";
              }
              newData.push({
                tid: item.tid,
                taskName: item.tname,
                status: status,
                endTime: item.end_time,
                detail: item.details
              });
            });
            this.tableData = newData;
            console.log(this.tableData);
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    beforeOpen() {
      if (this.active == 4) {
        this.editStatusText = "关闭";
      }
    },
    handleClose(done) {
      this.tempTid = "";
      this.editStatusText = "";
      this.queryMyTasks();
      this.isShow = false;
      done();
    },
    itemClick(row, column, cell, event) {
      console.log(row);
      this.tempTid = row.tid;
      this.dialogVisible = true;
      // if (row.status !== "已完成") {
      //   this.editStatusText = "下一步";
      // } else {
      //   this.editStatusText = "关闭";
      // }
      if (row.status == "待接受") {
        this.editStatusText = "下一步";
        this.active = 1;
      } else if (row.status == "待执行") {
        this.editStatusText = "下一步";
        this.active = 2;
      } else if (row.status == "执行中") {
        this.editStatusText = "下一步";
        this.active = 3;
      } else if (row.status == "已完成") {
        this.editStatusText = "关闭";
        this.isShow = true;

        this.active = 4;
      }
    },
    complete() {
      let params = qs.stringify({
        tid: this.tempTid,
        condition: "complete"
      });
      Axios.post("/maintain", params)
        .then(res => {
          console.log(res);
          this.tempTid = "";
          this.editStatusText = "";
          this.dialogVisible = false;
          this.queryMyTasks();
        })
        .catch(err => {
          alert(err);
        });
    }
  },
  mounted() {
    if (!this.$getCookie("username")) {
      this.$checkCookie("username");
    } else {
      this.queryMyTasks();
    }
  }
};
</script>
<style>
.el-table .warning-row {
  background: oldlace;
}

.el-table .success-row {
  background: #f0f9eb;
}
.el-table .waitGoing {
  background: #40f2ff;
}
.taskStatus {
  position: relative;
}
.taskStatus .tips {
  position: absolute;
  top: -120px;
  right: 50px;
}
.taskStatus .tips div {
  float: left;
  width: 60px;
  height: 20px;
  margin: 10px;
  font-size: 14px;
  color: #606266;
  line-height: 20px;
  text-align: center;
}
.tip1 {
  background-color: #fff;
}
.tip2 {
  background-color: rgb(253, 245, 230);
}
.tip3 {
  background-color: rgb(240, 249, 235);
}
.tip4 {
  background-color: #40f2ff;
}
</style>