import UserAuthApi from '../../api/UserAuth';
import axios from 'axios'

const AUTHENTICATING = "AUTHENTICATING";
const AUTHENTICATION_SUCCESS = "AUTHENTICATION_SUCCESS";
const AUTHENTICATION_ERROR = "AUTHENTICATION_ERROR";

const REGISTERING = "REGISTERING";
const REGISTRATION_SUCCESS = "REGISTRATION_SUCCESS";
const REGISTER_USER_ERROR = "REGISTER_USER_ERROR";

const LOGGING_OUT = "LOGGING_OUT";
const LOGOUT_SUCCESS = "LOGOUT_SUCCESS";
const LOGOUT_ERROR = "LOGOUT_ERROR";

const RESET_AUTH_STATE = "RESET_AUTH_STATE";

// const defaultState = {
//     isAuthenticated: false,
//     error: null,
//     isLoading: false,
//     token: localStorage.getItem('access_token') || null,
// };

const getDefaultState = () => {
    return {
        isAuthenticated: false,
        error: null,
        isLoading: false,
        token: localStorage.getItem('access_token') || null,
    }
  }

const mutations = {
    [AUTHENTICATING](state) {
        state.isLoading = true;
        state.error = null;
    },
    [AUTHENTICATION_SUCCESS](state, token) {
        state.error = null;
        state.isLoading = false;
        state.token = token
    },
    [AUTHENTICATION_ERROR](state, error) {
        state.error = error;
        state.isLoading = false
    },
    [REGISTERING](state) {
        state.isLoading = true;
        state.error = null;
    },
    [REGISTRATION_SUCCESS](state) {
        state.error = null;
        state.isLoading = false
    },
    [REGISTER_USER_ERROR](state, error) {
        state.error = error;
        state.isLoading = false
    },
    [LOGGING_OUT](state) {
        state.error = null;
        state.isLoading = true
    },
    [LOGOUT_ERROR](state, error) {
        state.error = error;
        state.isLoading = false
    },
    [LOGOUT_SUCCESS](state) {
        state.error = null;
        state.isLoading = false;
        state.token = null
    },
    [RESET_AUTH_STATE] (state) {
        Object.assign(state, getDefaultState())
      }
};

const actions = {
    async login({ commit }, payload) {
        commit(AUTHENTICATING);
        try {
            const response = await UserAuthApi.login(payload.username, payload.password);
            const token = response.data.access_token
            commit(AUTHENTICATION_SUCCESS, token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            localStorage.setItem('access_token', token)
            return response.data;
        } catch (error) {
            commit(AUTHENTICATION_ERROR, error);
            return null;
        }
    },
    async register({ commit }, payload) {
        commit(REGISTERING);
        try {
            const response = await UserAuthApi.register(payload.username, payload.email, payload.password);
            commit(REGISTRATION_SUCCESS);
            return response.data;
        } catch (error) {
            commit(REGISTER_USER_ERROR, error);
            return null;
        }
    },
    async logout({ commit }) {
        commit(LOGGING_OUT);
        try {
            const response = await UserAuthApi.logout();
            commit(LOGOUT_SUCCESS);
            delete axios.defaults.headers.common['Authorization'];
            localStorage.removeItem("access_token");
            return response.data;
        } catch (error) {
            commit(LOGOUT_ERROR, error);
            return null;
        }
    },
    resetAuthState ({ commit }) {
        commit(RESET_AUTH_STATE)
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
        return state.token ? true: false;
    }
};

export default {
    namespaced: true,
    state: getDefaultState(),
    getters,
    actions,
    mutations,
}