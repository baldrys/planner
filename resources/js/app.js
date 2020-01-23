import Vue from 'vue'
import App from './App.vue'

import store from './store'
import router from './router'
import axios from 'axios'

const token = localStorage.getItem('access_token')
console.log(token)
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

new Vue({
    el: '#app',
    components: {App},
    store: store,
    router
})