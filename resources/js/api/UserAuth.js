import axios from 'axios';

const LOGIN_URL = "/api/login";
const REGISTER_URL = "/api/register";

export default {
    login(username, password) {
        return axios.post(LOGIN_URL, { name: username, password: password });
    },
    register(username, email, password) {
        return axios.post(REGISTER_URL, { name: username, email:email, password: password });
    }
};