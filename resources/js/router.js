import Vue from "vue"
import Router from "vue-router"
import Home from './views/Home.vue'
import LoginFormView from './views/LoginForm'
import RegisterFormView from './views/RegisterForm'
import AdminView from './views/Admin'
import PersonalInfoView from './views/PersonalInfo'
import ActivitiesView from './views/Activities'
import HistoryView from './views/History'
import store from './store'
Vue.use(Router)

const DEFAULT_TITLE = 'Ежедненые активности';

const routes = [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                title: 'Главная страница',
                requiresAuth: true,
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
                layout: 'auth-layout'
            },
        },
        { 
            path: '/register', 
            component: RegisterFormView, 
            name: 'RegisterForm',
            meta: {
                title: 'Регистрация',
                requiresAuth: false,
                layout: 'auth-layout'
            }, 
        },
        { 
            path: '/admin', 
            component: AdminView, 
            name: 'admin',
            meta: {
                title: 'Административная панель',
                requiresAuth: true,
            }, 
        },
        { 
            path: '/personal-info', 
            component: PersonalInfoView, 
            name: 'personal',
            meta: {
                title: 'Персональная информация',
                requiresAuth: true,
                layout: 'default-layout'
            }, 
        },
        { 
            path: '/activities', 
            component: ActivitiesView, 
            name: 'activities',
            meta: {
                title: 'Активности',
                requiresAuth: true,
                layout: 'default-layout'
            }, 
        },
        { 
            path: '/history', 
            component: HistoryView, 
            name: 'history',
            meta: {
                title: 'История',
                requiresAuth: true,
                layout: 'default-layout'
            }, 
        },
    ]

let router = new Router({
    mode: "history",
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters["auth/isAuthenticated"]) {
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

export default router;