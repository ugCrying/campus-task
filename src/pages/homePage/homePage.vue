<template>
  <div>
    <task-list id="taskList"></task-list>
  </div>
</template>
<script>
import taskList from "@/components/taskList/taskList.vue";
export default {
  components: { taskList },
  data() {
    return {
      carouselOptions: []
    };
  }
};
</script>
<style>
/* 轮播图样式 */
.el-carousel__item h3 {
  color: #475669;
  font-size: 14px;
  opacity: 0.75;
  line-height: 200px;
  margin: 0;
  text-align: center;
}

.el-carousel__item:nth-child(2n) {
  background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: #d3dce6;
}
</style>


