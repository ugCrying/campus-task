import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import homePage from '@/pages/homepage/homePage.vue'
import taskList from '@/components/taskList/taskList.vue'
import personal from '@/components/personal/personal.vue'
import login from '@/components/login/login.vue'
import userInfo from '@/components/userInfo/userInfo'
import userInfoEdit from '@/components/userInfoEdit/userInfoEdit.vue'
import assign from '@/components/task/assign'
import taskStatus from '@/components/task/taskStatus'
Vue.use(Router)
export default new Router({
  routes: [{
      path: '/',
      name: "homePage",
      component: homePage
    },
    {
      path: '/hello',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/taskList',
      name: 'taskList',
      component: taskList
    },
    {
      path: '/personal',
      name: "personal",
      component: personal
    },
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '/userInfo',
      name: 'userInfo',
      component: userInfo
    },
    {
      path: '/userInfoEdit',
      name: 'userInfoEdit',
      component: userInfoEdit
    },
    {
      path: '/assign',
      name: 'assign',
      component: assign
    },
    {
      path: '/taskStatus',
      name: 'taskStatus',
      component: taskStatus
    },
  ]
})
