<template>
  <div class="header">
    <el-row style="height:36px;">
      <el-col :span="24" style="height:100%;position:relative;" class="grid-content bg-purple">
        <h1 style="float:left;">Campus Task</h1>
        <el-autocomplete
          v-model="searchMsg"
          :fetch-suggestions="querySearchAsync"
          placeholder="请输入内容"
          @select="handleSelect"
          style="position:absolute;right:0;line-height:36px;"
        >
          <i class="el-icon-search" slot="suffix" @click="searchClick" style="cursor:pointer"></i>
        </el-autocomplete>
      </el-col>
    </el-row>

    <el-row>
      <el-col :offset="3" :span="21">
        <div class="grid-content bg-purple" id="menu-box">
          <el-menu
            :default-active="activeIndex"
            class="el-menu-demo"
            mode="horizontal"
            :router="true"
            active-background-color="#ffd04b"
          >
            <el-col :span="9"></el-col>
            <el-menu-item index="1" style="text-align:center" route="/taskList">任务栏</el-menu-item>
            <el-submenu index="2">
              <template slot="title" style="text-align:center">个人中心</template>
              <el-menu-item index="2-1" route="/userInfo">个人信息</el-menu-item>
              <el-menu-item index="2-2" route="/userInfoEdit">资料完善</el-menu-item>
              <el-menu-item index="2-3">好友关注</el-menu-item>
              <el-menu-item index="2-4">我的主页</el-menu-item>
              <el-submenu index="2-4">
                <template slot="title">其他</template>
                <el-menu-item index="2-4-1">隐私</el-menu-item>
                <el-menu-item index="2-4-2">帮助</el-menu-item>
              </el-submenu>
            </el-submenu>
            <el-menu-item index="3" style="text-align:center">消息中心</el-menu-item>
            <el-submenu index="4">
              <template slot="title" style="text-align:center">任务管理</template>
              <el-menu-item index="4-1" route="/assign">任务发布</el-menu-item>
              <el-menu-item index="4-2" route="/taskStatus">任务状态维护</el-menu-item>
            </el-submenu>
            <!-- <el-menu-item index="4" style="text-align:center" route="taskList">任务管理</el-menu-item> -->
          </el-menu>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
export default {
  data() {
    return { activeIndex: "1", restaurants: [], searchMsg: "", timeout: null };
  },
  methods: {
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    },
    loadSearchOption() {
      return [
        { value: "三全鲜食（北新泾店）", address: "长宁区新渔路144号" },
        {
          value: "Hot honey 首尔炸鸡（仙霞路）",
          address: "上海市长宁区淞虹路661号"
        }
      ];
    },
    querySearchAsync(queryString, cb) {
      var restaurants = this.restaurants;
      var results = queryString
        ? restaurants.filter(this.createStateFilter(queryString))
        : restaurants;

      clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
        cb(results);
      }, 3000 * Math.random());
    },
    createStateFilter(queryString) {
      return state => {
        return (
          state.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
        );
      };
    },
    searchClick(item) {
      console.log(this.searchMsg);
    }
  },
  mounted() {
    this.restaurants = this.loadSearchOption();
  }
};
</script>


<style>
.header .el-input__suffix {
  cursor: pointer;
}
.el-menu-demo {
  display: inline-block;
  margin: 0 auto;
}
#menu-box {
  text-align: center;
}
.grid-content {
  border-radius: 4px;
  min-height: 36px;
}
.bg-purple {
  /* background: #d3dce6; */
}
.header .el-input__inner {
  height: 25px;
}
/* 搜索框标题label */
.el-form-item__label {
  line-height: 36px;
}
.el-form-item__content {
  line-height: 36px;
}
/* form表单item */
.el-form-item {
  margin-bottom: 0;
}
.el-menu.el-menu--horizontal {
  border-bottom: none;
}
</style>

