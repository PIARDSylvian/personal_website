import API from "../api/api";

const FETCHING_POST = "FETCHING_POST",
    FETCHING_POST_SUCCESS = "FETCHING_POST_SUCCESS",
    FETCHING_POST_ERROR = "FETCHING_POST_ERROR";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        posts: []
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        hasMenu(state) {
            return state.posts.length > 0;
        },
        posts(state) {
            return state.posts;
        }
    },
    mutations: {
        [FETCHING_POST](state) {
            state.isLoading = true;
            state.error = null;
            state.posts = [];
        },
        [FETCHING_POST_SUCCESS](state, posts) {
            state.isLoading = false;
            state.error = null;
            state.posts = posts;
        },
        [FETCHING_POST_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.posts = [];
        }
    },
    actions: {
        async getPosts({ commit }) {
            commit(FETCHING_POST);
            try {
                let response = await API.getPosts();
                commit(FETCHING_POST_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(FETCHING_POST_ERROR, error);
                return null;
            }
        }
    }
};