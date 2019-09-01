export default {
  data() {
    return {

    }
  },
  methods: {
    // ---------------------------------登陆cookie控制-------------------------------------------
    // setCookie(cname, cvalue, exdays) {
    //   let d = new Date();
    //   d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    //   let expires = "expires=" + d.toGMTString();
    //   document.cookie = cname + "=" + cvalue + "; " + expires;
    // },
    // getCookie(cname) {
    //   let name = cname + "=";
    //   let ca = document.cookie.split(";");
    //   for (let i = 0; i < ca.length; i++) {
    //     let c = ca[i].trim();
    //     if (c.indexOf(name) == 0) {
    //       return c.substring(name.length, c.length);
    //     }
    //   }
    //   return "";
    // },
    // checkCookie() {
    //   let user = this.getCookie("username");
    //   if (user != "") {
    //     alert("欢迎 " + user + " 再次访问");
    //   } else {
    //     user = prompt("请输入你的名字:", "");
    //     if (user != "" && user != null) {
    //       this.setCookie("username", user, 30);
    //     }
    //   }
    // },
    // logout() {
    //   document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    // }
  }
}
