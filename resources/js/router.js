import Vue from "vue"
import Router from "vue-router"
import Home from './views/Home.vue'
import LoginFormView from './views/LoginForm'
import RegisterFormView from './views/RegisterForm'
import AdminView from './views/Admin'
import PersonalInfoView from './views/PersonalInfo'

Vue.use(Router)



const routes = [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                title: 'Главная страница',
                layout: 'default-layout'
            }
        },
        { 
            path: '/login/', 
            component: LoginFormView, 
            name: 'LoginForm',
            props: true,
            meta: {
                title: 'Вход',
                requiresAuth: true,
                layout: 'auth-layout'
            },
        },
        { 
            path: '/register', 
            component: RegisterFormView, 
            name: 'RegisterForm',
            meta: {
                title: 'Регистрация',
                layout: 'auth-layout'
            }, 
        },
        { 
            path: '/admin', 
            component: AdminView, 
            name: 'admin',
            meta: {
                title: 'Административная панель',
                requiresAuth: true
            }, 
        },
        { 
            path: '/personal-info', 
            component: PersonalInfoView, 
            name: 'personal',
            meta: {
                title: 'Персональная информация',
                requiresAuth: true
            }, 
        },
    ]

let router = new Router({
    mode: "history",
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        this.$store.dispatch('auth/resetAuthState');
        if (store.getters["security/isAuthenticated"]) {
            next();
        } else {
            next({
                path: "/login",
                query: { redirect: to.fullPath }
            });
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export default new Router({
    mode: 'history',
    routes: routes
})