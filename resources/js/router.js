import Vue from "vue"
import Router from "vue-router"
import Home from './views/Home.vue'
import LoginFormView from './views/LoginForm'
import RegisterFormView from './views/RegisterForm'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        { 
            path: '/login/', 
            component: LoginFormView, 
            name: 'LoginForm',
            props: true
        },
        { path: '/register', component: RegisterFormView, name: 'RegisterForm' },
    ]
})