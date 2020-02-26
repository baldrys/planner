import axios from 'axios';

export default {
    getUrl() {
        const userId = localStorage.getItem('user_id');
        return `/api/users"/${userId}`;
    },
    updateUser(username, email, password) {
        return axios.patch(this.getUrl(), { name: username, email: email, password: password });
    }
};