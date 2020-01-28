import UserAuthApi from '../../api/UserAuth';
import axios from 'axios'

const AUTHENTICATING = "AUTHENTICATING";
const AUTHENTICATION_SUCCESS = "AUTHENTICATION_SUCCESS";
const AUTHENTICATION_ERROR = "AUTHENTICATION_ERROR";




const getDefaultState = () => {
    return {
        error: null,
        isLoading: false,
        user: null
    }
  }

const mutations = {

};

const actions = {


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
    getMyInfo(state) {
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