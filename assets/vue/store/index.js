import Vue from "vue";
import Vuex from "vuex";
import MenuModule from "./menu";
import PostModule from "./post";
import SearchModule from "./search";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        menu: MenuModule,
        post: PostModule,
        search: SearchModule
    }
});