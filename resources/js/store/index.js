import Vue from "vue"
import Vuex from "vuex"
import auth from './modules/auth'
import user from './modules/users'
import activities from './modules/activities'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
        user,
        activities
    }
})