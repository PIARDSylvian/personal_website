import API from "../api/api";

const FETCHING_SEARCH = "FETCHING_SEARCH",
    FETCHING_MORE = "FETCHING_MORE",
    FETCHING_SEARCH_SUCCESS = "FETCHING_SEARCH_SUCCESS",
    FETCHING_SEARCH_MORE_SUCCESS = "FETCHING_SEARCH_MORE_SUCCESS",
    FETCHING_SEARCH_ERROR = "FETCHING_SEARCH_ERROR",
    FETCHING_SEARCH_END = "FETCHING_SEARCH_END";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        isMore: false,
        error: null,
        posts: [],
        search: null,
        isEnd: false
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        isMore(state) {
            return state.isMore;
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
        }
    },
    mutations: {
        [FETCHING_SEARCH](state) {
            state.isLoading = true;
            state.error = null;
        },
        [FETCHING_MORE](state) {
            state.isMore = true;
        },
        [FETCHING_SEARCH_SUCCESS](state, posts) {
            state.isLoading = false;
            state.error = null;
            state.posts = posts.data;
            state.search = posts.search;
        },
        [FETCHING_SEARCH_MORE_SUCCESS](state, posts) {
            state.isMore = false;
            state.error = null;
            state.posts = state.posts.concat(posts.data);
        },
        [FETCHING_SEARCH_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.posts = [];
        },
        [FETCHING_SEARCH_END](state, status) {
            state.isEnd = status;
        }
    },
    actions: {
        async getSearch({ commit }, args) {
            if(args.more===false) {
                commit(FETCHING_SEARCH);
            } else {
                commit(FETCHING_MORE);
               args.search = this.state.search.search
            }
            try {
                
                let response = await API.getPosts(args.search, args.offset, args.category);
                commit(FETCHING_SEARCH_END, (response.data.length < 1));
                if(args.more===false) {
                    commit(FETCHING_SEARCH_SUCCESS, {data:response.data, search:args.search});
                } else {
                    commit(FETCHING_SEARCH_MORE_SUCCESS, {data:response.data});
                }
                return response.data;
            } catch (error) {
                commit(FETCHING_SEARCH_ERROR, error);
                return null;
            }
        }
    }
};