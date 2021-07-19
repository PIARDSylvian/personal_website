/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';
import 'bootstrap';

// start the Vue application
import Vue from "vue";
import App from "./App";
import router from "./router/index";
import store from "./store";

new Vue({
	components: { App },
	template: "<App/>",
	store,
	router
}).$mount("#app");