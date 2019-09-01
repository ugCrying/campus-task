// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import axios from 'axios'
Vue.prototype.$axios = axios;
import qs from 'qs'
Vue.prototype.$qs = qs;

axios.defaults.baseURL = 'http://localhost'
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

//全局注册组件
import userController from "@/components/userController/userController";
Vue.component("userController", userController)
//全局cookie方法
import {
  setCookie,
  getCookie,
  deleteCookie,
  checkCookie
} from '@/common/cookieMethods.js';
Vue.prototype.$checkCookie = checkCookie;
Vue.prototype.$getCookie = getCookie;
Vue.prototype.$deleteCookie = deleteCookie;
Vue.prototype.$setCookie = setCookie;


Vue.config.productionTip = false
Vue.use(ElementUI);
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: {
    App
  },
  template: '<App/>'
})
