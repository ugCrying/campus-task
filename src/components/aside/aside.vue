<template>
  <div id="aside-app">
    <div id="box">
      <div class="contentDiv">
        <img src="../../../static/testPicture/1.jpg">
      </div>
    </div>
    <ul id="userWindow">
      <li>
        <label @click="login">{{username}}</label>
      </li>
      <li>
        <label>信用等级</label>
      </li>
      <li v-if="lououtShow">
        <label @click="logout">注销</label>
      </li>
    </ul>
    <user-controller ref="userController"></user-controller>
  </div>
</template>
<script>
export default {
  data() {
    return {
      username: "",
      lououtShow: this.$getCookie("username")
    };
  },
  mounted() {
    let cName = this.$getCookie("nickname");
    if (cName == "") {
      this.username = "请登录";
    } else {
      this.username = cName;
    }
    // console.log(this.username);
  },
  watch: {
    username(val) {}
  },
  methods: {
    login() {
      // this.username == "" ? "请登录" : this.username;
      this.$checkCookie();
    },
    logout() {
      if (!this.$getCookie("username")) {
        return false;
      }
      this.$deleteCookie();
      this.username = "请登录";
      location.reload();
    }
  }
};
</script>

<style>
#aside-app {
  color: #333;
  height: 100%;
}
#box {
  width: 100%;
  height: 140px;
  text-align: center;
  position: relative;
}
.contentDiv {
  display: inline-block;
  margin: 0px auto;
  width: 100px;
  height: 100px;
  border-radius: 100px;
  -webkit-border-radius: 100px;
  -moz-border-radius: 100px;
  border: 2px solid #fff;
  box-shadow: 0 0 4px #ccc;
  overflow: hidden;
  /* 水平垂直居中 */
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
/*图片的样式*/
.contentDiv img {
  width: 100%;
  min-height: 100%;
}
#userWindow li {
  text-align: center;
  cursor: pointer;
}
#userWindow li label {
  font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
    "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  font-size: 14px;
  color: #909399;
  cursor: pointer;
  display: inline-block;
  margin-bottom: 10px;
  line-height: 45px;
  width: 100%;
  font-weight: bold;
}
#userWindow li :hover {
  color: #303133;
}
</style>
