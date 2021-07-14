import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Test from "../views/Test";
import store from "../store";

Vue.use(VueRouter);

let routes = [{ path: "/", name: "home", component: Home }];
let router = new VueRouter({
  mode: "history",
  routes: routes
});

(async function() {
  Promise.all([store.dispatch("menu/getMenu"), store.dispatch("post/getPosts")]).then((values) => {
    values[0].forEach(link => {
      let url = '/'+link.name.replace(/\s/g, "").toLowerCase()
      router.addRoute({ path: url, name: url, component: Test })
    })
    router.addRoute({ path: "*", redirect: "/" })
  });
})();

export default router