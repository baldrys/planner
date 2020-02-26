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

const FETCHING_USER = "FETCHING_USER";
const FETCH_USER_SUCCESS = "FETCH_USER_SUCCESS";
const FETCH_USER_ERROR = "FETCH_USER_ERROR";

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
        user: {
            id: '',
            name: '',
            email: '',
            role: '',
        }
    }
  }

const mutations = {
    [AUTHENTICATING](state) {
        state.isLoading = true;
        state.error = null;
    },
    [AUTHENTICATION_SUCCESS](state, token, user) {
        state.error = null;
        state.isLoading = false;
        state.token = token;
        state.user = user
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
        state.token = null;
        state.user = {
            id: '',
            name: '',
            email: '',
            role: '',
        }
    },
    [RESET_AUTH_STATE] (state) {
        Object.assign(state, getDefaultState())
    },
    [FETCHING_USER](state) {
        state.error = null;
        state.isLoading = true
    },
    [FETCH_USER_SUCCESS](state, user) {
        state.error = null;
        state.isLoading = false
        state.user = user
    },
    [FETCH_USER_ERROR](state, error) {
        state.error = error;
        state.isLoading = false;
        state.user = null
    },
};

const actions = {
    async login({ commit, dispatch, getters}, payload) {
        commit(AUTHENTICATING);
        try {
            const responseLogin = await UserAuthApi.login(payload.username, payload.password);
            const token = responseLogin.data.access_token
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            localStorage.setItem('access_token', token);
            const responseGetUserInfo = await UserAuthApi.getUserInfo();
            const user = responseGetUserInfo.data.data;
            localStorage.setItem('user_id', user.id,);
            commit(AUTHENTICATION_SUCCESS, token, user);
            return responseLogin.data;
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
            localStorage.removeItem("user_id");
            return response.data;
        } catch (error) {
            commit(LOGOUT_ERROR, error);
            return null;
        }
    },
    resetAuthState ({ commit }) {
        commit(RESET_AUTH_STATE)
      },
    async getUserInfo({ commit }) {
        commit(FETCHING_USER);
        try {
            const response = await UserAuthApi.getUserInfo();
            const user = {
                id: response.data.data.id,
                name:  response.data.data.name,
                email: response.data.data.email,
                role: response.data.data.role,
            };
            commit(FETCH_USER_SUCCESS, user);
            return user;
        } catch (error) {
            commit(FETCH_USER_ERROR, error);
            console.log(error);
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
        return state.token ? true: false;
    },
    isAdmin(state) {
        return state.user.role == 'Admin' ? true: false;
    },
    getUser(state) {
        return state.user;
    }
};

export default {
    namespaced: true,
    state: getDefaultState(),
    getters,
    actions,
    mutations,
}