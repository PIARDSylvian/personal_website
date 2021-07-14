import axios from "axios";

export default {
	getMenu() {
		return axios.get("/api/menu");
	},
	getPosts() {
		return axios.get("/api/post");
	},
	getPost(slug) {
		return axios.get("/api/post",{ params: { slug: slug } });
	}
};