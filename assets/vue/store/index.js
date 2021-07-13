import Vue from "vue";
import Vuex from "vuex";
import MenuModule from "./menu";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        menu: MenuModule
    }
});