import axios from 'axios';
import store from '../store'

const USER_URL = "/api/users";


export default {
    updateUser(username, email, password) {
        const USER = store.getters['auth/getUser'];
        return axios.patch( USER_URL + "/" + USER.id, { name: username, email: email, password: password });
    }
};