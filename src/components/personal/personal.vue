<template>
  <div>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">昵称</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.nickname"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">年龄</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.age"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">性别</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.gender"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">学号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.studentNumber">1</span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">班级</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.class"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">真实姓名</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.realname"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">身份证号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.IDnumber"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">手机号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.cellphoneNumber"></span>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">信用等级</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <span class="infoItemRight" v-html="testData.rating"></span>
      </el-col>
    </el-row>

    <el-row style="text-align:center;margin:30px">
      <el-button type="small" @click="edit">编辑</el-button>
    </el-row>
    <user-controller ref="userController"></user-controller>
  </div>
</template>
<script>
import Axios from "axios";
import qs from "qs";

export default {
  beforeRouteEnter(to, from, next) {
    // let cName = this.$getCookie("username");
    let cName = "";
    if (cName == "" || cName == null) {
      // this.$refs["userController"].loginVisble = true;
      console.log("hahahah");
    } else {
      next();
    }
  },
  data() {
    return {
      userMsg: {
        username: "", //账号
        nickname: "", //昵称
        userPwd: "", //密码
        age: "", //年龄
        gender: "", //性别
        studentNumber: "", //学号
        class: "", //班级
        realname: "", //真实姓名
        IDnumber: "", //身份证号
        cellphoneNumber: "", //手机号
        rating: ""
      },
      testData: {
        username: "123456", //账号
        nickname: "张三", //昵称
        userPwd: "11111", //密码
        age: "21", //年龄
        gender: "男", //性别
        studentNumber: "15320220200", //学号
        class: "信息管理系信息系统2班", //班级
        realname: "大张", //真实姓名
        IDnumber: "510123189874146585", //身份证号
        cellphoneNumber: "19814578543", //手机号
        rating: "优"
      }
    };
  },
  methods: {
    edit() {
      Axios.get("/index.php/index/index/hello").then(res => {
        console.log(res.data);
      });
    }
  },
  mounted() {
    console.log("personal mounted");
  }
};
</script>

<style>
.infoItemLeft {
  float: right;
  line-height: 40px;
  font-size: 14px;
}
.infoItemRight {
  line-height: 40px;
  font-size: 14px;
}
</style>
