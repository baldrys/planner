import UserApi from '../../api/User';
import axios from 'axios'

const UPDATING = "UPDATING";
const UPDATING_SUCCESS = "UPDATING_SUCCESS";
const UPDATING_ERROR = "UPDATING_ERROR";
import store from '../../store'


const getDefaultState = () => {
    return {
        error: null,
        isLoading: false
    }
  }

const mutations = {
    [UPDATING](state) {
        state.isLoading = true;
        state.error = null;
    },
    [UPDATING_SUCCESS](state, user) {
        state.error = null;
        state.isLoading = false;
        store.state.auth.user.name = user.name;
        store.state.auth.user.email = user.email;
    },
    [UPDATING_ERROR](state, error) {
        state.error = error;
        state.isLoading = false
    },
};

const actions = {
    async update({ commit }, payload) {
        commit(UPDATING);
        try {
            const response = await UserApi.updateUser(payload.name, payload.email, payload.password);
            const updatedUser = response.data.data;
            commit(UPDATING_SUCCESS, updatedUser);
            return response.data;
        } catch (error) {
            commit(UPDATING_ERROR, error);
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
};

export default {
    namespaced: true,
    state: getDefaultState(),
    getters,
    actions,
    mutations,
}