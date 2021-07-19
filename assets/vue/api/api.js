import axios from "axios";

export default {
	getMenu() {
		return axios.get("/api/menu");
	},
	getPosts(search, offset, category) {
		return axios.get("/api/posts",{ params: { keyword: search, offset: offset, category: category} });
	},
	getPost(slug) {
		return axios.get("/api/posts/"+slug);
	}
};