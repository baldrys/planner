import Vue from "vue"
import Router from "vue-router"
import Home from './views/Home.vue'
import LoginFormView from './views/LoginForm'
import RegisterFormView from './views/RegisterForm'
import AdminView from './views/Admin'

Vue.use(Router)



const routes = [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                title: 'Главная страница'
            }
        },
        { 
            path: '/login/', 
            component: LoginFormView, 
            name: 'LoginForm',
            props: true,
            meta: {
                title: 'Вход',
                requiresAuth: true
            },
        },
        { 
            path: '/register', 
            component: RegisterFormView, 
            name: 'RegisterForm',
            meta: {
                title: 'Регистрация'
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