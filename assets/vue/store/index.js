import Vue from "vue";
import Vuex from "vuex";
import MenuModule from "./menu";
import PostModule from "./post";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        menu: MenuModule,
        post: PostModule
    }
});