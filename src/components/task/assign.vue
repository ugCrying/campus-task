<template>
  <div class="assign">
    <el-form ref="form" :model="form" label-width="80px">
      <el-form-item label="任务名称" prop="taskName">
        <el-col :span="5">
          <el-input v-model="form.taskName"></el-input>
        </el-col>
      </el-form-item>
      <el-form-item label="发布方式" prop="assignType">
        <el-select v-model="form.assignType" placeholder="请选择">
          <el-option label="公共发布" value="public"></el-option>
          <el-option label="指定派发" value="private"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="有效期至" prop="endTime">
        <el-date-picker
          @change="getTime"
          v-model="form.endTime"
          type="datetime"
          placeholder="选择日期时间"
        ></el-date-picker>
      </el-form-item>
      <el-form-item label="任务类型" prop="taskType">
        <el-checkbox-group @change="checkVal" v-model="form.taskType">
          <el-checkbox label="美食/餐厅任务" name="type"></el-checkbox>
          <el-checkbox label="代领取物件" name="type"></el-checkbox>
          <el-checkbox label="购物" name="type"></el-checkbox>
          <el-checkbox label="资料打印" name="type"></el-checkbox>
          <el-checkbox label="其它" name="type"></el-checkbox>
        </el-checkbox-group>
      </el-form-item>
      <el-form-item label="是否匿名" prop="radio">
        <el-radio-group @change="checkVal" v-model="form.radio">
          <el-radio label="1">否</el-radio>
          <el-radio label="2">是</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="赏金" prop="bonus">
        <el-input-number style="height:40px" v-model="form.bonus" :min="1" :max="100000" label="赏金"></el-input-number>
      </el-form-item>
      <el-form-item label="任务内容" prop="taskDetail">
        <el-input type="textarea" style="width:60%" v-model="form.taskDetail"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="assignTask">立即发布</el-button>
        <el-button @click="reset">取消</el-button>
      </el-form-item>
    </el-form>
    <user-controller ref="userController"></user-controller>
  </div>
</template>
<script>
import Axios from "axios";
import qs from "qs";
export default {
  data() {
    return {
      form: {
        taskName: "",
        assignType: "",
        endTime: "",
        taskType: [],
        taskDetail: "",
        radio: "1",
        bonus: "",
        time: ""
      }
    };
  },
  methods: {
    assignTask() {
      if (
        this.form.taskName == "" ||
        this.form.assignType == "" ||
        this.form.taskDetail == ""
      ) {
        return false;
      }
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
        username: this.$getCookie("username"),
        tname: this.form.taskName,
        createTime: time,
        endTime: this.form.endTime,
        taskDetail: this.form.taskDetail,
        bonus: this.form.bonus,
        nickname: this.$getCookie("nickname")
      });
      Axios.post("/assignTask", params)
        .then(res => {
          this.reset();
          if (res.data.errCode == 0) {
            this.$message({
              message: "恭喜,任务发布成功！",
              type: "success"
            });
            this.$router.push({
              path: "/taskList"
            });
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    reset() {
      this.$refs.form.resetFields();
    },
    onSubmit() {
      console.log("submit!");
    },
    checkVal(val) {
      console.log(val);
    },
    getTime(val) {
      var d = new Date(val);
      this.form.endTime =
        d.getFullYear() +
        "-" +
        (d.getMonth() + 1) +
        "-" +
        d.getDate() +
        " " +
        d.getHours() +
        ":" +
        d.getMinutes() +
        ":" +
        d.getSeconds();
      console.log(this.form.endTime);
    }
  }
};
</script>
<style scoped>
/* .assign .el-input {
  line-height: 40px;
  width: 40%;
}
.assign el-select {
  line-height: 40px;
  width: 40%;
} */
.assign .el-form-item {
  margin-bottom: 20px;
}
.assign .el-input__inner {
  /* line-height: 40px; */
}
</style>
