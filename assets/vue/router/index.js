import Vue from "vue";
import VueRouter from "vue-router";
import Posts from "../views/Posts";
import Post from "../views/Post";
import Search from "../views/Search";
import store from "../store";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes: [{ path: "/", name: "home", component: Posts, props: true}, { path: "/search", name: "search", component: Search}],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

function findPost(route) {
  let findPost = null
  store.getters["post/posts"].some(function(post){
    if(post.slug === route.params.slug){
      return findPost = post
    }
  });
  return {post : findPost};
}

(function() {
  Promise.all([store.dispatch("menu/getMenu")]).then((values) => {
    values[0].forEach(link => {
      link.url = '/'+link.name.replace(/\s/g, "").toLowerCase();
      router.addRoute({ path: link.url, name: link.name, component: Posts, props: {category : link}});
      router.addRoute({ path: link.url+'/:slug', name: link.name+'/post', component: Post, props: findPost});
    });
    router.addRoute({ path: "*", redirect: "/" });
    store.dispatch("menu/populated")
  }).then(store.dispatch("post/getPosts", {more:false, category:null, offset:0, search:null}));
  
})();

export default router