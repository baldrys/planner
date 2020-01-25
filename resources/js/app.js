import Vue from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import axios from 'axios'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate)

const token = localStorage.getItem('access_token')
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

new Vue({
    el: '#app',
    components: {App},
    store: store,
    router
})