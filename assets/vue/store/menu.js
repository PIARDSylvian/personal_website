import MenuAPI from "../api/menu";

const FETCHING_MENU = "FETCHING_MENU",
    FETCHING_MENU_SUCCESS = "FETCHING_MENU_SUCCESS",
    FETCHING_MENU_ERROR = "FETCHING_MENU_ERROR";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        menu: []
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
            return state.menu.length > 0;
        },
        menu(state) {
            return state.menu;
        }
    },
    mutations: {
        [FETCHING_MENU](state) {
            state.isLoading = true;
            state.error = null;
            state.menu = [];
        },
        [FETCHING_MENU_SUCCESS](state, menu) {
            state.isLoading = false;
            state.error = null;
            state.menu = menu;
        },
        [FETCHING_MENU_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.menu = [];
        }
    },
    actions: {
        async getMenu({ commit }) {
            commit(FETCHING_MENU);
            try {
                let response = await MenuAPI.getMenu();
                commit(FETCHING_MENU_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(FETCHING_MENU_ERROR, error);
                return null;
            }
        }
    }
};