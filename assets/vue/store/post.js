import API from "../api/api";

const FETCHING_POSTS = "FETCHING_POST",
    FETCHING_POSTS_SUCCESS = "FETCHING_POSTS_SUCCESS",
    FETCHING_POST_SUCCESS = "FETCHING_POST_SUCCESS",
    FETCHING_POSTS_ERROR = "FETCHING_POSTS_ERROR",
    FETCHING_POSTS_END = "FETCHING_POSTS_END";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        posts: [],
        isEnd: []
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
        posts(state) {
            return state.posts;
        },
        isEnd(state) {
            return state.isEnd;
        },
        postsById: (state) => (id) => { 
            return state.posts.filter(post => post.category.id === id) 
        }
    },
    mutations: {
        [FETCHING_POSTS](state) {
            state.isLoading = true;
            state.error = null;
        },
        [FETCHING_POSTS_SUCCESS](state, posts) {
            state.isLoading = false;
            state.error = null;
            state.posts =  state.posts.concat(posts);
        },
        [FETCHING_POSTS_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.posts = [];
        },
        [FETCHING_POST_SUCCESS](state) {
            state.isLoading = false;
            state.error = null;
        },
        [FETCHING_POSTS_END](state, category) {
            let endTab = state.isEnd
            endTab[category] = true;
            state.isEnd = endTab;
        }
    },
    actions: {
        async getPosts({ commit }, args) {
            if(args.more===false) {
                commit(FETCHING_POSTS);
            }
            try {
                let response = await API.getPosts(args.search, args.offset, args.category);
                commit(FETCHING_POSTS_SUCCESS, response.data);
                if(response.data.length < 1) {
                    if (args.category == null) { args.category = 0 }
                    commit(FETCHING_POSTS_END, args.category, true);
                }
                return response.data;
            } catch (error) {
                commit(FETCHING_POSTS_ERROR, error);
                return null;
            }
        },
        async getPost({ commit }, slug) {
            commit(FETCHING_POSTS);
            try {
                let response = await API.getPost(slug);
                commit(FETCHING_POST_SUCCESS);
                return response.data;
            } catch (error) {
                commit(FETCHING_POSTS_ERROR, error);
                return null;
            }
        }
    }
};