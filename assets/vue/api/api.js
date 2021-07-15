import axios from "axios";

export default {
	getMenu() {
		return axios.get("/api/menu");
	},
	getPosts() {
		return axios.get("/api/posts");
	},
	getPost(slug) {
		return axios.get("/api/posts",{ params: { slug: slug } });
	}
};