<template>
  <div class="userInfoEdit">
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">昵称</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.nickname"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">生日</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.birthday"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">性别</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.gender"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">学号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.studentNumber"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">班级</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.class"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">寝室号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.dormitary"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">真实姓名</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.realname"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">身份证号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.IDnumber"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">手机号</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input v-model.trim="userMsg.cellphoneNumber"></el-input>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="8">
        <span class="infoItemLeft">信用等级</span>
      </el-col>
      <el-col :span="15" :offset="1">
        <el-input disabled v-model.trim="userMsg.rating"></el-input>
      </el-col>
    </el-row>

    <el-row style="text-align:center;margin:30px">
      <el-button type="small" @click="returnToInfo">取消</el-button>

      <el-button type="small" @click="update">保存</el-button>
    </el-row>
    <user-controller ref="userController"></user-controller>
  </div>
</template>
<script>
import Axios from "axios";
import qs from "qs";

export default {
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
      }
      // testData: {
      //   username: "123456", //账号
      //   nickname: "张三", //昵称
      //   userPwd: "11111", //密码
      //   age: "21", //年龄
      //   gender: "男", //性别
      //   studentNumber: "15320220200", //学号
      //   class: "信息管理系信息系统2班", //班级
      //   realname: "大张", //真实姓名
      //   IDnumber: "510123189874146585", //身份证号
      //   cellphoneNumber: "19814578543", //手机号
      //   rating: "优"
      // }
    };
  },
  methods: {
    update() {
      let cName = this.$getCookie("username");
      let params = qs.stringify({
        username: cName,
        nickname: this.userMsg.nickname,
        birthday: this.userMsg.birthday,
        gender: this.userMsg.gender,
        studentNumber: this.userMsg.studentNumber,
        class: this.userMsg.class,
        dormitary: this.userMsg.dormitary,
        realname: this.userMsg.realname,
        IDnumber: this.userMsg.IDnumber,
        cellphoneNumber: this.userMsg.cellphoneNumber
      });
      Axios.post("/updateUserInfo", params)
        .then(res => {
          console.log(res);
          if (res.data.errCode == 0) {
            this.$message({
              type: "success",
              message: "修改成功！"
            });
            this.$router.push({
              path: "/userInfo"
            });
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    returnToInfo() {
      this.$router.push({
        path: "/userInfo"
      });
    }
  },
  mounted() {
    let cName = this.$getCookie("username");
    if (cName == "" || cName == null) {
      this.$refs["userController"].loginVisible = true;
    } else {
      let params = qs.stringify({
        username: cName
      });
      Axios.post("/userInfo", params)
        .then(res => {
          console.log(res);
          let newData = {
            username: res.data.result[0].username, //账号
            nickname: res.data.result[0].nickname, //昵称
            // age: res.data.result[0].age, //年龄
            birthday: res.data.result[0].birthday,
            gender: res.data.result[0].gender, //性别
            studentNumber: res.data.result[0].studentNumber, //学号
            class: res.data.result[0].class, //班级
            dormitary: res.data.result[0].dormitary,
            realname: res.data.result[0].realname, //真实姓名
            IDnumber: res.data.result[0].IDnumber, //身份证号
            cellphoneNumber: res.data.result[0].cellphone, //手机号
            rating: res.data.result[0].rating
          };
          this.userMsg = newData;
        })
        .catch(err => {
          alert(err, this);
        });
    }
  }
};
</script>

<style scoped>
.infoItemLeft {
  float: right;
  line-height: 40px;
  font-size: 14px;
}
.infoItemRight {
  line-height: 40px;
  font-size: 14px;
}
.userInfoEdit .el-input {
  line-height: 40px;
  width: 50%;
}
.userInfoEdit .el-input__inner {
  /* height: 30px !important; */
}
</style>
