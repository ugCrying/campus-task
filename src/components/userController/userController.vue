
<template>
  <div>
    <el-dialog title="登录" :visible.sync="loginVisible" width="25%">
      <el-form
        status-icon
        validate-on-rule-change
        :model="form"
        :rules="rules"
        ref="form"
        :hide-required-asterisk="true"
      >
        <el-form-item
          label="用户名"
          :label-width="formLabelWidth"
          style="margin-bottom:50px"
          prop="username"
        >
          <el-input class="myInput" size="medium" v-model.trim="form.username" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="密码" :label-width="formLabelWidth" prop="password">
          <el-input
            class="myInput"
            size="medium"
            v-model.trim="form.password"
            show-password
            autocomplete="off"
          ></el-input>
        </el-form-item>
      </el-form>
      <div class="dialogFooter">
        <div class="btnBox">
          <el-button @click="submitForm('form','login')">登 录</el-button>
          <el-button type="primary" @click="startReg">注 册</el-button>
          <el-button @click="toChange">修改密码</el-button>
        </div>
      </div>
    </el-dialog>
    <!-- ---------------------------------------注册------------------------------------------- -->
    <el-dialog title="注册" :visible.sync="regVisible" width="25%">
      <el-form status-icon :model="form" :rules="rules" ref="form" :hide-required-asterisk="true">
        <el-form-item
          label="用户名"
          :label-width="formLabelWidth"
          style="margin-bottom:50px"
          prop="regName"
        >
          <el-input class="myInput" size="medium" v-model.trim="form.regName" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item
          label="密码"
          :label-width="formLabelWidth"
          prop="regPwd"
          style="margin-bottom:50px"
        >
          <el-input
            show-password
            class="myInput"
            size="medium"
            v-model.trim="form.regPwd"
            autocomplete="off"
          ></el-input>
        </el-form-item>
        <el-form-item label="确认密码" :label-width="formLabelWidth" prop="regPwd1">
          <el-input
            class="myInput"
            show-password
            size="medium"
            v-model.trim="form.regPwd1"
            autocomplete="off"
          ></el-input>
        </el-form-item>
      </el-form>
      <div class="dialogFooter">
        <div class="btnBox">
          <el-button @click="backToLogin">返回登录</el-button>
          <el-button type="primary" @click="submitForm('form','reg')">确认注册</el-button>
        </div>
      </div>
    </el-dialog>
    <!-- ---------------------------------------修改密码------------------------------------------- -->
    <el-dialog title="修改密码" :visible.sync="changeVisible" width="25%">
      <el-form status-icon :model="form" :rules="rules" ref="form" :hide-required-asterisk="true">
        <el-form-item
          label="旧密码"
          :label-width="formLabelWidth"
          style="margin-bottom:50px"
          prop="oldPwd"
        >
          <el-input
            show-password
            class="myInput"
            size="medium"
            v-model.trim="form.oldPwd"
            autocomplete="off"
          ></el-input>
        </el-form-item>
        <el-form-item
          label="新密码"
          :label-width="formLabelWidth"
          prop="newPwd"
          style="margin-bottom:50px"
        >
          <el-input
            show-password
            class="myInput"
            size="medium"
            v-model.trim="form.newPwd"
            autocomplete="off"
          ></el-input>
        </el-form-item>
        <el-form-item label="确认密码" :label-width="formLabelWidth" prop="newPwd2">
          <el-input
            show-password
            class="myInput"
            size="medium"
            v-model.trim="form.newPwd2"
            autocomplete="off"
          ></el-input>
        </el-form-item>
      </el-form>
      <div class="dialogFooter">
        <div class="btnBox">
          <el-button @click="cancelChange()">取消</el-button>
          <el-button type="primary" @click="submitForm('form','changePwd')">确认修改</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Axios from "axios";
import qs from "qs";
export default {
  data() {
    // -----------------------注册-----------------------
    let validateRegPwd = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请输入密码"));
      } else {
        if (this.form.checkPass !== "") {
          this.$refs.form.validateField("checkPass");
        }
        callback();
      }
    };
    let validateRegPwd2 = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请再次输入密码"));
      } else if (value !== this.form.regPwd) {
        callback(new Error("两次输入密码不一致!"));
      } else {
        callback();
      }
    };
    // -----------------------修改密码-----------------------
    let validateNewPwd = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请输入新密码"));
      } else if (value === this.form.oldPwd) {
        callback(new Error("请勿与旧密码相同"));
      } else {
        if (this.form.checkPass !== "") {
          this.$refs.form.validateField("checkPass");
        }
        callback();
      }
    };
    let validateNewPwd2 = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请再次输入新密码"));
      } else if (value !== this.form.newPwd) {
        callback(new Error("两次输入密码不一致!"));
      } else if (value === this.form.oldPwd) {
        callback(new Error("请勿与旧密码相同"));
      } else {
        callback();
      }
    };
    return {
      loginVisible: false,
      regVisible: false,
      changeVisible: false,
      form: {
        username: "",
        password: "",
        regName: "",
        regPwd: "",
        regPwd1: "",
        oldPwd: "",
        newPwd: "",
        newPwd2: ""
      },
      usernameMsg: "",
      pwdMsg: "",
      formLabelWidth: "120px",
      rules: {
        username: [
          { required: true, message: "请输入用户名", trigger: "blur" },
          { min: 6, max: 18, message: "长度在 6 到 18 个字符", trigger: "blur" }
        ],
        password: [
          { required: true, message: "请输入密码", trigger: "blur" },
          { min: 3, max: 18, message: "长度在 3 到 18 个字符", trigger: "blur" }
        ],
        regName: [
          { required: true, message: "请输入用户名", trigger: "blur" },
          { min: 6, max: 18, message: "长度在 6 到 18 个字符", trigger: "blur" }
        ],
        regPwd: [
          {
            min: 3,
            max: 18,
            message: "长度在 3 到 18 个字符",
            trigger: "blur"
          },
          { validator: validateRegPwd, trigger: "blur" }
        ],
        regPwd1: [
          { validator: validateRegPwd2, trigger: "blur" },
          { min: 3, max: 18, message: "长度在 3 到 18 个字符", trigger: "blur" }
        ],
        oldPwd: [
          { required: true, message: "请输入旧密码", trigger: "blur" },
          { min: 3, max: 18, message: "长度在 3 到 18 个字符", trigger: "blur" }
        ],
        newPwd: [
          { validator: validateNewPwd, trigger: "blur" },
          { min: 3, max: 18, message: "长度在 3 到 18 个字符", trigger: "blur" }
        ],
        newPwd2: [
          { validator: validateNewPwd2, trigger: "blur" },
          { min: 3, max: 18, message: "长度在 3 到 18 个字符", trigger: "blur" }
        ]
      }
    };
  },
  methods: {
    // ---------------------表单验证-------------------------
    submitForm(formName, val) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          this[val]();
        }
      });
    },
    // ---------------------登陆验证-------------------------
    login() {
      let params = qs.stringify({
        username: this.form.username,
        password: this.form.password
      });
      Axios.post("/login", params)
        .then(res => {
          if (res.data.errCode !== 0) {
            this.$confirm(res.data.errMsg, "错误", {
              confirmButtonText: "返回",
              showCancelButton: false,
              type: "error",
              center: true
            });
            return false;
          } else {
            this.$confirm(res.data.errMsg, "成功", {
              confirmButtonText: "确定",
              showCancelButton: false,
              type: "success",
              center: true
            });
            this.$setCookie("username", this.form.username, 30);
            // ==存昵称
            this.$setCookie("nickname", res.data.result[0].nickname);
            this.loginVisible = false;
            location.reload();
          }
        })
        .catch(err => {
          alert(err, this);
        });
    },
    startReg() {
      this.regVisible = true;
    },
    // --------------------注册--------------------------
    reg() {
      let params = qs.stringify({
        regName: this.form.regName,
        regPwd: this.form.regPwd
      });
      Axios.post("/reg", params)
        .then(res => {
          console.log(res);
          if (res.data.errCode !== 0) {
            this.$confirm(res.data.errMsg, "错误", {
              confirmButtonText: "返回",
              showCancelButton: false,
              type: "error",
              center: true
            });
            return false;
          } else {
            this.$confirm(res.data.errMsg, "成功", {
              confirmButtonText: "确定",
              showCancelButton: false,
              type: "success",
              center: true
            });
          }
        })
        .catch(err => {
          alert(err);
        });
    },
    backToLogin() {
      this.regVisible = false;
    },
    // ------------------修改密码------------------------
    toChange() {
      this.changeVisible = true;
    },
    cancelChange() {
      this.form.oldPwd = this.form.newPwd = this.form.newPwd2 = "";
      this.changeVisible = false;
    },
    changePwd() {
      let params = qs.stringify({
        username: "123",
        oldPwd: this.form.oldPwd,
        newPwd: this.form.newPwd
      });
      Axios.post("/changePwd", params)
        .then(res => {
          console.log(res);
          if (res.data.errCode !== 0) {
            this.$confirm(res.data.errMsg, "错误", {
              confirmButtonText: "重新输入",
              showCancelButton: false,
              type: "error",
              center: true
            });
            return false;
          } else {
            this.$confirm(res.data.errMsg, "成功", {
              confirmButtonText: "确定",
              showCancelButton: false,
              type: "success",
              center: true
            });
          }
          this.changeVisible = false;
        })
        .catch(err => {
          console.log(err);
        });
    },
    //路由来回跳转用以刷新
    reflashPage() {
      let NewPage = "_empty" + "?time=" + new Date().getTime() / 500;
      this.$router.push(NewPage);
      this.$router.go(-1);
    }
  }
};
</script>
<style scoped>
.dialogFooter {
  margin-top: 50px;
  text-align: center;
}
.myInput {
  width: 75%;
}
.btnBox {
  margin: 0 auto;
}
</style>
