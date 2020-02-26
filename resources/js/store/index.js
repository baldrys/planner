import Vue from "vue"
import Vuex from "vuex"
import auth from './modules/auth'
import user from './modules/users'
import activities from './modules/activities'
import dayActivities from './modules/dayActivities'

Vue.use(Vuex)





let store = new Vuex.Store({
    modules: {
        auth,
        user,
        activities,
        dayActivities
    }
})

store.watch((state) => store.getters['auth/isAuthenticated'], (newValue, oldValue) => {
    if(newValue === true) {
        store.dispatch('auth/getUserInfo').then(
            () => {
                if (store.getters['auth/hasError']) {
                    console.log(this.error)
                }
            }
        );
    }
})

export default store;