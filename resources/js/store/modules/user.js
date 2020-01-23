import UserAuthApi from '../../api/UserAuth';

const AUTHENTICATION_SUCCESS = "AUTHENTICATION_SUCCESS";
const AUTHENTICATION_ERROR = "AUTHENTICATION_ERROR";
const REGISTER_USER_ERROR = "REGISTER_USER_ERROR";

const defaultState = {
    user: null,
    isAuthenticated: false,
    error: null,
    isLoading: false
};

const mutations = {
    [AUTHENTICATION_SUCCESS](state, user) {
        state.error = null;
        state.isAuthenticated = true;
        state.user = user;
    },
    [AUTHENTICATION_ERROR](state, error) {
        state.error = error;
        state.isAuthenticated = false;
        state.user = null;
    },
    [REGISTER_USER_ERROR](state, error) {
        state.error = error;
        state.isAuthenticated = false;
        state.user = null;
    },
};

const actions = {
    async login({ commit }, payload) {
        try {
            const response = await UserAuthApi.login(payload.username, payload.password);
            commit(AUTHENTICATION_SUCCESS, response.data);
            return response.data;
        } catch (error) {
            commit(AUTHENTICATION_ERROR, error);
            return null;
        }
    },
    async register({ commit }, payload) {
        try {
            const response = await UserAuthApi.register(payload.username, payload.email, payload.password);
            return response.data;
        } catch (error) {
            commit(REGISTER_USER_ERROR, error);
            return null;
        }
    },
};

const getters = {
    hasError(state) {
        return state.error !== null;
    },
    error(state) {
        return state.error;
    },
    isLoading(state) {
        return state.isLoading;
    },
    isAuthenticated(state) {
        return state.isAuthenticated;
    },
    user(state) {
        return state.user;
    }
};

export default {
    namespaced: true,
    state: defaultState,
    getters,
    actions,
    mutations,
}