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
	findCategory(route);
	let findPost = null
	store.getters["post/posts"].some(function(post){
		if(post.slug === route.params.slug){
			return findPost = post
		}
	});
	return {post : findPost};
}

function findCategory(route) {
	let findCategory = null
	store.getters["menu/menu"].some(function(category){
		if(category.slug === route.params.category){
			return findCategory = category
		}
	});
	if (findCategory === null) {
		router.push({name:"home"}); // TODO 404 NOT FOUND
	}
	return {category : findCategory};
}

(function() {
	Promise.all([store.dispatch("menu/getMenu")]).then((values) => {
		router.addRoute({ path: '/:category', name: 'category', component: Posts, props: findCategory});
		router.addRoute({ path: '/:category/:slug', name: 'post', component: Post, props: findPost});
		router.addRoute({ path: "*", redirect: "/" });
		store.dispatch("menu/populated")
	}).then(store.dispatch("post/getPosts", {more:false, category:null, offset:0, search:null}));
})();

export default router