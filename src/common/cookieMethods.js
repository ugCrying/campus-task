// ---------------------------------登陆cookie控制-------------------------------------------
export function setCookie(cname, cvalue, exdays) {
  let d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toGMTString();
  document.cookie = cname + "=" + cvalue + "; " + expires;
  console.log(document.cookie);
}
export function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i].trim();
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
export function checkCookie() {
  let user = getCookie("username");
  console.log(user);
  if (user != "") {
    console.log("欢迎 " + user + " 再次访问");
  } else {
    this.$refs["userController"].loginVisible = true;
    // user = prompt("请输入你的名字:", "");
    // if (user != "" && user != null) {
    //   this.loginVisible = true;
    //   this.setCookie("username", this.form.username, 30);
    // }
  }
}
export function deleteCookie() {
  document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "nickname=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
}
