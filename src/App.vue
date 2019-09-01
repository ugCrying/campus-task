<template>
  <div id="app" ref="app" class="app">
    <el-container id="container" :style="heightAdjust()">
      <el-row id="header">
        <my-header></my-header>
      </el-row>
      <div class="clear-float"></div>
      <el-row id="container-row">
        <el-col :span="3" id="aside">
          <my-aside></my-aside>
        </el-col>
        <el-col :span="20" id="main">
          <router-view v-if="isRouterAlive"></router-view>
        </el-col>
      </el-row>
      <el-footer>
        <my-footer></my-footer>
      </el-footer>
    </el-container>
    <user-controller ref="userController"></user-controller>
  </div>
</template>

<script>
import myAside from "@/components/aside/aside.vue";
import myHeader from "@/components/header/header.vue";
import myFooter from "@/components/footer/footer.vue";
import Axios from "axios";
import qs from "qs";

export default {
  name: "App",
  components: {
    myAside,
    myHeader,
    myFooter
  },
  watch: {
    $route(to, from) {
      console.log(to);
    }
  },
  provide() {
    return {
      reload: this.reload
    };
  },
  data() {
    return {
      isRouterAlive: true,
      height: ""
    };
  },
  methods: {
    reload() {
      this.isRouterAlive = false;
      this.$nextTick(function() {
        this.isRouterAlive = true;
      });
    },
    heightAdjust() {
      return "min-height:" + window.innerHeight + "px";
    }
  },
  created() {},
  beforeMount() {},
  mounted() {}
};
</script>

<style>
#app {
  font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
    "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  margin: 0;
  padding: 0;
  position: relative;
}
* {
  margin: 0;
  padding: 0;
}
a {
  text-decoration: none;
}
ul li {
  list-style-type: none;
}
.clear-float {
  clear: both;
}
.app {
}

#container {
  display: block;
  min-height: 100%;
  width: 70%;
  margin: 0 auto;
  position: relative;
  padding-bottom: 60px;
}
#container-row {
  width: 100%;
}
.el-footer {
  background-color: #b3c0d1;
  position: absolute;
  bottom: 0;
  width: 100%;
}
#aside {
  background-color: #d3dce6;
  height: 400px;
  margin-top: 50px;
  border-radius: 4px;
}
/* 媒体查询aside */
@media screen and (max-width: 1150px) {
  #aside {
    display: none;
  }
}
#main {
  color: #333;
  height: 100%;
  float: right;
  background-color: #d3dce6;
  padding-top: 60px;
  /* text-align: center; */
}

/* #app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
} */
</style>
